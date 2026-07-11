<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class MenuManagement extends Component
{
    public $name, $price, $category, $image_url;

    public function saveMenu()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:burger,drinks,sides',
            'image_url' => 'required|url',
        ]);

        // Simpan langsung ke database Supabase
        DB::table('menus')->insert([
            'name' => $this->name,
            'price' => $this->price,
            'category' => $this->category,
            'image_url' => $this->image_url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->reset(['name', 'price', 'category', 'image_url']);
        session()->flash('success', 'Menu baru berhasil ditambahkan!');
    }

    public function deleteMenu($id)
    {
        DB::table('menus')->where('id', $id)->delete();
        session()->flash('success', 'Menu berhasil dihapus dari sistem!');
    }

    public function render()
    {
        $menus = DB::table('menus')->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.menu-management', ['menus' => $menus])->layout('layouts.app');
    }
}