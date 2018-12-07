<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        return Field::all( );
    }
}
