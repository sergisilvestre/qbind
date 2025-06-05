<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex flex-row align-items-center justify-content-center p-5" style="min-height: 100vh">
        <div>
            <div class="row m-0">
                <div class="col-12 p-5">
                    <h1 class="text-center">{{ config('app.name') }}</h1>
                </div>
                <form class="col-6" action="{{ route('validateVatNumer') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Individual validation
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter VAT number"
                                    name="vat_number" value="{{ old('vat_number') }}" required autocomplete="off">
                                <button class="btn btn-secondary" type="submit">Validate</button>
                            </div>
                        </div>
                        @if (session('message'))
                            <div @class([
                                'bg-success' => session('message') === 'Valid',
                                'bg-danger' => session('message') !== 'Valid',
                                'card-footer',
                                'text-white',
                            ])>
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>

                </form>
                <form class="col-6" action="{{ route('upload') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Upload VAT numbers file
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="file" class="form-control" accept=".csv" name="vat_numbers">
                                <button class="btn btn-secondary" type="submit">Upload</button>
                            </div>
                        </div>
                        @error('vat_numbers')
                            <div class="card-footer text-white bg-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </form>
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header bg-secondary text-white">
                            VAT Numbers
                        </div>
                        <div class="card-body p-0">
                            @if (isset($vatNumbersValidated))

                                <table class="table table-striped table-hover m-0">
                                    <tr>
                                        <th>Original VarNumber</th>
                                        <th>Correction message</th>
                                        <th>Validated VAT Number</th>
                                    </tr>
                                    @foreach ($vatNumbersValidated as $vatNumber)
                                        <tr>
                                            <td @class([
                                                'bg-success' => $vatNumber->isValid,
                                                'bg-danger' => !$vatNumber->isValid,
                                                'text-white',
                                            ]) class="text-nowrap">
                                                {{ $vatNumber->originalVatNumber }}</td>
                                            <td @class([
                                                'bg-success' => $vatNumber->isValid,
                                                'bg-danger' => !$vatNumber->isValid,
                                                'text-white',
                                            ]) class="text-nowrap">
                                                {{ isset($vatNumber->correctionMessage) ? $vatNumber->correctionMessage : null }}
                                            </td>
                                            <td @class([
                                                'bg-success' => $vatNumber->isValid,
                                                'bg-danger' => !$vatNumber->isValid,
                                                'text-white',
                                            ]) class="text-nowrap w-100">
                                                {{ isset($vatNumber->vatNumberValidated) ? $vatNumber->vatNumberValidated : null }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <table class="table table-striped table-hover m-0">
                                    @foreach ($vatNumbers as $vatNumber)
                                        <tr>
                                            <td>{{ $vatNumber->vat_number }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
