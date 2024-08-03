<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Categoria;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

#[Lazy()]
class Categorias extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $nombre, $slug, $imagen, $mMethod, $mTitle, $idm;
    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Title(['Categorias', 'Mantenimiento'])]
    public function render()
    {
        $categorias = Categoria::where('nombre', 'LIKE', "%" . $this->search . "%")
            ->orderBy('nombre')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.categorias', compact('categorias'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVA CATEGORIA';
        $this->mMethod = 'store';
        $this->reset(['nombre']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|unique:categorias,nombre'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'La categoria ya existe'
        ]);

        Categoria::create([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Categoria registrada']);
    }

    public function aimagen($id)
    {
        $this->mTitle = 'IMAGEN DE CATEGORIA';
        $this->mMethod = 'simagen';
        $this->reset(['imagen']);
        $this->resetValidation();
        $categoria = Categoria::find($id);
        $this->idm = $categoria->id;
        $this->dispatch('smi');
    }

    public function simagen()
    {
        $this->validate([
            'imagen' => 'required|image|max:512',
        ], [
            'imagen.required' => 'La imagen es obligatoria',
            'imagen.image' => 'Elija una imagen',
            'imagen.max' => 'La imagen no debe ser mayor a 512Kb',
        ]);

        $categoria = Categoria::find($this->idm);
        if ($this->imagen) {
            $imagen = $this->imagen->storeAs('categorias', date('YmdHis') . '.' . $this->imagen->getClientOriginalExtension(), 'public');
        }
        if ($categoria->imagen) {
            if (file_exists(public_path('storage/' . $categoria->imagen))) {
                unlink(public_path('storage/' . $categoria->imagen));
            }
        }
        $categoria->update([
            'imagen' => $imagen,
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('hmi', ['t' => 'success', 'm' => '¡Hecho!<br>Imagen actualizada']);
    }

    public function edit($id)
    {
        $this->mTitle = 'EDITAR CATEGORIA';
        $this->mMethod = 'update';
        $categoria = Categoria::find($id);
        $this->idm = $categoria->id;
        $this->nombre = $categoria->nombre;
        $this->reset(['imagen']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $this->idm
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'La categoria ya existe'
        ]);

        Categoria::find($this->idm)->update([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre),
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Categoria actualizada']);
    }

    public function state($id)
    {
        $categoria = Categoria::find($id);
        $categoria->update([
            'estado' => $categoria->estado ? null : 1,
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('rd', ['t' => 'success', 'm' => '¡Hecho!<br>Estado actualizado']);
    }

    #[On('delete')]
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if ($categoria->productos->count()) {
            $this->dispatch('rd', ['t' => 'error', 'm' => '¡Error!<br>La categoria tiene productos registrados']);
        }else{
            if ($categoria->imagen) {
                if (file_exists(public_path('storage/' . $categoria->imagen))) {
                    unlink(public_path('storage/' . $categoria->imagen));
                }
            }
            $categoria->delete();
            $this->dispatch('rd', ['t' => 'success', 'm' => '¡Hecho!<br>Categoria eliminada']);
        }
    }
}
