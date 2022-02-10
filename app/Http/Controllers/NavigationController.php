<?php

namespace App\Http\Controllers;

use App\Http\Requests\NavigationRequest;
use App\Services\NavigationService;
use Illuminate\Support\Str;

class NavigationController
{

    public function navigate(
        NavigationRequest $request,
        NavigationService $navigation
    ) {
        $width        = $request->input('width');
        $height       = $request->input('height');
        $originX      = $request->input('originX');
        $originY      = $request->input('originY');
        $orientation  = Str::upper($request->input('orientation'));
        $instructions = Str::upper($request->input('instructions'));

        // calculate the relative surface area for each square on X and Y
        $relativeWidth  = round($width / 2, 1);
        $relativeHeight = round($height / 2, 1);
        if (abs($originX) > $relativeWidth || abs($originY) > $relativeHeight) {
            return response()->json('The surface and origin data is wrong',
                400);
        }

        try {
            $navigation->setLocation($originX, $originY, $orientation);
            for ($i = 0; $i < strlen($instructions); $i++) {
                $navigation->makeTurn($instructions[$i]);
                if (abs($navigation->getLatitude()) > $relativeWidth || abs($navigation->getLongitude()) > $relativeHeight) {
                    $commands     = Str::substr($instructions, 0, $i + 1);
                    $errorMessage = sprintf('Vehicle out of limits. Commands executed: [%s]. Last point located: (%s, %s)',
                        $commands, $navigation->getLongitude(),
                        $navigation->getLatitude());
                    return response()->json($errorMessage, 400);
                }
            }

            $missionReport = sprintf('Mission successful. Last point located: (%s, %s)',
                $navigation->getLongitude(), $navigation->getLatitude());
            return response()->json($missionReport);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

}
