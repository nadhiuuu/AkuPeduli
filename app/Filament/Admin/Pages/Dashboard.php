<?php

namespace App\Filament\Admin\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    // Mengubah nama menu di bilah navigasi kiri
    protected static ?string $navigationLabel = 'Dashboard'; 

    // Mengubah judul besar di bagian atas halaman
    protected ?string $heading = 'Dashboard AkuPeduli!!'; 
}
