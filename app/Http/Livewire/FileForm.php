<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\File;

class FileForm extends Component
{
    use WithFileUploads;
    public $title;
	public $name;

    public function submit()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'name' => 'required',
        ]);

        $filename = $this->name->store('files','public');

        $validatedData['name']=$filename;

        File::create($validatedData);

        session()->flash('message', 'File successfully Uploaded.');

        return redirect()->to('/form-file');
    }

    public function render()
    {
        return view('livewire.file-form');
    }
}