@extends('layouts.app')

@section('title', 'Random password generator')

@section('content')
    <form id="password-generator--form">
        @csrf
        <div>
            <label id="password-generator--length-label" for="password-generator--length">Type number of symbols</label>
            <input type="number" name="password_length" id="password-generator--length" min="6" max="62" value="6">
        </div>
        <div id="password-generator--affix-options">
            <div>
                <input type="checkbox" name="password_affix_list[]" value="numbers" id="password-generator--join-numbers" checked>
                <label id="password-generator--join-numbers-label" for="password-generator--join-numbers">Include numbers</label>
            </div>
            <div>
                <input type="checkbox" name="password_affix_list[]" value="upper_case" id="password-generator--join-capital-letters" checked>
                <label id="password-generator--join-capital-letters-label" for="password-generator--join-capital-letters">Include capital letters</label>
            </div>
            <div>
                <input type="checkbox" name="password_affix_list[]" value="lower_case" id="password-generator--join-regular-letters" checked>
                <label id="password-generator--join-regular-letters-label" for="password-generator--join-regular-letters">Include regular letters</label>
            </div>
        </div>
    </form>

    <div id="password-generator--actions">
        <button id="password-generator--generate" type="button">Generate</button>
    </div>

    <div id="password-generator--result">

    </div>
@endsection
