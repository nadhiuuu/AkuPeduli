<?php

namespace App\Filament\Admin\Resources\Documentations\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Str;
class DocumentationForm
{
    
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('campaign_id')
                    ->relationship(
                        name : 'campaign',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn ($query) => $query->where('status', 'aktif')
                        ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                    )
                    ->required()
                    ->preload()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($set, $state) {

                        $campaign = \App\Models\Campaign::find($state);

                        if ($campaign) {
                            $set('slug', \Illuminate\Support\Str::slug($campaign->title));
                        }
                    }),

                DatePicker::make('tgl_penyerahan')
                    ->required()
                    ->minDate(now()),

                TextInput::make('nama_penerima')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->hidden()
                    ->dehydrated(),

                RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('bukti_foto')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('documentation')
                    ->visibility('public') 
                    ->maxSize(2048),

                    
            ]);
    }
}
