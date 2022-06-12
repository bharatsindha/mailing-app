<?php

namespace App\Imports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Modules\Mail\Entities\Attachment;
use Modules\Mail\Entities\Compose;
use Modules\Mail\Entities\Session;
use Throwable;

class ComposeImport implements ToCollection, WithHeadingRow
{
    const COLLECTION_FORMAT = [
        'first_name', 'last_name', 'to', 'cc', 'bcc', 'designation', 'project_name', 'company_name'
    ];
    const VALIDATION_RULES = [
        'to'  => 'required|email',
        'cc'  => 'nullable|email',
        'bcc' => 'nullable|email',
    ];
    private $request = null;
    private $validated = false;
    private $errorMessages = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Collection $collection
     * @throws ValidationException
     */
    public function collection(Collection $collection)
    {
        // If data not found in sheet
        if ($collection->count() == 0) {
            array_push($this->errorMessages, "Could not found data in excel sheet.");
        }

        // Check excel sheet having data
        // Validate the columns
        // Validate the data
        if ($collection->count() > 0) {
            $columnNames = array_map('trim', array_keys($collection[0]->toArray()));

            // If excel sheet format does not match
            if ($columnNames === self::COLLECTION_FORMAT) {
                $this->validated = true;

                // Validate the data
                foreach ($collection->toArray() as $key => $row) {
                    $row = array_map('trim', $row);

                    // Validate the data with rules
                    $validator = Validator::make($row, self::VALIDATION_RULES);
                    // If validation fails
                    if ($validator->fails()) {
                        $errors = [];
                        $this->validated = false;

                        // Collect the validation errors
                        foreach ($validator->getMessageBag()->toArray() as $errorKey => $errorValue)
                            array_push($errors, implode(' ', $errorValue));

                        array_push(
                            $this->errorMessages,
                            implode(' ', $errors) . " Error in Row No. " . ($key + 2)
                        );
                    }
                }
            } else {
                array_push($this->errorMessages, "Excel sheet columns are not in the same format.");
            }
        }

        // If  data validated
        if ($this->validated) {
            try {
                DB::beginTransaction();
                // Save session
                $session = new Session($this->request->all());
                $session->user_id = Auth::user()->id;
                $session->save();

                // Save compose data for the session
                foreach ($collection->toArray() as $key => $row) {
                    $compose = new Compose($row);
                    $compose->email_id = $this->request->email_id;
                    $session->composes()->save($compose);
                }

                // Sync compose count with session
                $session->total_emails = $session->composes()->count();
                $session->save();

                // If attachment attached for the session
                // Save attachment(s) for the session
                if (isset($this->request->attachments) &&
                    !is_null($this->request->attachments) &&
                    !empty($this->request->attachments) &&
                    is_array($this->request->attachments)) {

                    foreach ($this->request->attachments as $aKey => $adata) {
                        $adata = json_decode(stripslashes($adata), true);
                        // Save attachment for the session
                        $attachment = new Attachment($adata);
                        $session->attachments()->save($attachment);
                    }
                }

                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                $this->validated = false;
                array_push($errorMessages, 'Something went wrong. Error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Return the flag of data validation
     *
     * @return bool
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * Return the error messages
     *
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

}
