<?php

namespace App\Http\Controllers;

use App\Models\VatNumber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $vatNumbers = [], $vatNumbersValidated = [];

    public function index()
    {
        $vatNumbers = VatNumber::all();

        return view('home', compact('vatNumbers'));
    }

    public function validateVatNumer(Request $request)
    {
        $request->validate([
            'vat_number' => 'required',
        ]);

        $vatNumber = $request->input('vat_number');

        return redirect()->back()->with('message', $this->isValid($vatNumber) ? 'Valid' : 'Invalid')->withInput();
    }

    public function upload(Request $request)
    {
        VatNumber::truncate();

        $this->validateFile($request);
        $this->validateVarNumbers();
        $this->storeVatNumbers();

        $vatNumbersValidated = $this->vatNumbersValidated;

        return view('home', compact('vatNumbersValidated'));
    }

    public function validateFile($request)
    {

        $request->validate(['vat_numbers' => 'required|file|mimes:csv']);
        $file = $request->file('vat_numbers');
        $this->vatNumbers = array_map('str_getcsv', file($file->getRealPath()));
    }

    public function validateVarNumbers()
    {
        foreach ($this->vatNumbers as $row) {

            if (isset($row[0]) && !empty($row[0])) {

                $originalVatNumber = trim($row[1]);

                if ($this->isValid($originalVatNumber)) {

                    $this->addToValidatedList($originalVatNumber, true, 'Valid', $originalVatNumber);
                } else if ($this->isCorrected($originalVatNumber)) {

                    $vatNumberValidated = 'IT' . $originalVatNumber;

                    $this->addToValidatedList($originalVatNumber, true, 'Corrected to IT format', $vatNumberValidated);
                } else if ($this->isTooShort($originalVatNumber)) {

                    $this->addToValidatedList($originalVatNumber, false, 'Too short');
                } else {

                    $this->addToValidatedList($originalVatNumber, false, 'No valid');
                }
            }
        }
    }

    public function isValid($vatNumber)
    {
        $vatNumber = strtoupper(trim($vatNumber));

        return preg_match('/^IT\d{11}$/', $vatNumber);
    }

    public function isCorrected($vatNumber)
    {
        return preg_match('/^\d{11}$/', $vatNumber);
    }

    public function isTooShort($vatNumber)
    {
        return preg_match('/^IT\d{1,10}$/', $vatNumber);
    }

    public function addToValidatedList($originalVatNumber, $isValid, $correction_message, $vatNumberValidated = null,)
    {
        array_push($this->vatNumbersValidated, (object)[
            'originalVatNumber'     => $originalVatNumber,
            'isValid'               => $isValid,
            'correctionMessage'     => $correction_message,
            'vatNumberValidated'    => $vatNumberValidated,
        ]);
    }

    public function storeVatNumbers()
    {
        foreach ($this->vatNumbersValidated as $vatNumber) {

            if ($vatNumber->isValid && !VatNumber::where('vat_number', $vatNumber->vatNumberValidated)->exists()) {

                $vatNumber = strtoupper(trim($vatNumber->vatNumberValidated));

                VatNumber::create(['vat_number' => $vatNumber]);
            }
        }
    }
}
