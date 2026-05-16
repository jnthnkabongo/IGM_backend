<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LotController extends Controller
{
    public function generateImage($id)
    {
        $lot = Lot::with(['production.site', 'production.zone', 'production.minerai', 'production.responsable'])->find($id);
        
        if (!$lot) {
            return response()->json(['error' => 'Lot non trouvé'], 404);
        }

        // Générer le QR code
        $qrCode = Builder::create()
            ->data($lot->numero)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->build();

        $qrCodePath = storage_path('app/temp/qr_' . $lot->id . '.png');
        $qrCode->saveToFile($qrCodePath);

        // Créer l'image avec les informations
        $manager = new ImageManager(new Driver());
        $image = $manager->create(800, 600)->fill('ffffff');
        
        // En-tête
        $image->text('FICHE LOT', 400, 50, function($font) {
            $font->size(32);
            $font->color('1e40af');
            $font->align('center');
        });
        
        // Informations du lot
        $y = 100;
        $lineHeight = 35;
        
        $info = [
            'Numéro: ' . $lot->numero,
            'Quantité: ' . number_format($lot->quantite, 2) . ' kg',
            'Quantité restante: ' . number_format($lot->quantite_restante, 2) . ' kg',
            'Statut: ' . ucfirst($lot->statut),
        ];
        
        if ($lot->production) {
            $info[] = 'Date production: ' . $lot->production->date_production;
            if ($lot->production->site) {
                $info[] = 'Site: ' . $lot->production->site->nom;
            }
            if ($lot->production->zone) {
                $info[] = 'Zone: ' . $lot->production->zone->nom;
            }
            if ($lot->production->minerai) {
                $info[] = 'Minerai: ' . $lot->production->minerai->nom;
            }
        }
        
        foreach ($info as $line) {
            $image->text($line, 50, $y, function($font) {
                $font->size(18);
                $font->color('000000');
            });
            $y += $lineHeight;
        }
        
        // Ajouter le QR code
        $qrImage = $manager->read($qrCodePath);
        $image->place($qrImage, 'bottom-right', 20, 20);
        
        // Sauvegarder l'image
        $outputPath = storage_path('app/temp/lot_' . $lot->id . '.png');
        $image->save($outputPath);
        
        // Nettoyer le fichier QR temporaire
        if (file_exists($qrCodePath)) {
            unlink($qrCodePath);
        }
        
        // Retourner l'image
        return response()->file($outputPath)->deleteFileAfterSend(true);
    }
}
