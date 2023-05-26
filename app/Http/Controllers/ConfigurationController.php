<?php

namespace App\Http\Controllers;

use App\Models\CDN\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigurationController extends Controller
{
    public function view()
    {
        $upload_domain = Config::where([
            'meta' => 'upload_domain'
        ])->first();

        $ads_header = Config::where([
            'meta' => 'ads_header'
        ])->first();

        $ads_body = Config::where([
            'meta' => 'ads_body'
        ])->first();

        $ads_footer = Config::where([
            'meta' => 'ads_footer'
        ])->first();

        $ads_script = Config::where([
            'meta' => 'script_ads'
        ])->first();
        return view('configuration.index', [
            'upload_domain' => $upload_domain ? $upload_domain->value : '',
            'ads_header' => $ads_header ? $ads_header->value : '',
            'ads_body' => $ads_body ? $ads_body->value : '',
            'ads_footer' => $ads_footer ? $ads_footer->value : '',
            'ads_script' => $ads_script ? $ads_script->value : ''
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload_domain' => 'nullable',
            'ads_header' => 'nullable',
            'ads_body' => 'nullable',
            'ads_footer' => 'nullable',
            'ads_script' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $upload_domain = Config::where([
            'meta' => 'upload_domain'
        ])->first();

        if (!$upload_domain) {
            Config::create([
                'meta' => 'upload_domain',
                'value' => $request->upload_domain ? $request->upload_domain : ''
            ]);
        } else {
            $upload_domain->update([
                'value' => $request->upload_domain ? $request->upload_domain : ''
            ]);
        }

        $ads_header = Config::where([
            'meta' => 'ads_header'
        ])->first();

        if (!$ads_header) {
            Config::create([
                'meta' => 'ads_header',
                'value' => $request->ads_header ? $request->ads_header : ''
            ]);
        } else {
            $ads_header->update([
                'value' => $request->ads_header ? $request->ads_header : ''
            ]);
        }

        $ads_body = Config::where([
            'meta' => 'ads_body'
        ])->first();

        if (!$ads_body) {
            Config::create([
                'meta' => 'ads_body',
                'value' => $request->ads_body ? $request->ads_body : ''
            ]);
        } else {
            $ads_body->update([
                'value' => $request->ads_body ? $request->ads_body : ''
            ]);
        }

        $ads_footer = Config::where([
            'meta' => 'ads_footer'
        ])->first();

        if (!$ads_footer) {
            Config::create([
                'meta' => 'ads_footer',
                'value' => $request->ads_footer ? $request->ads_footer : ''
            ]);
        } else {
            $ads_footer->update([
                'value' => $request->ads_footer ? $request->ads_footer : ''
            ]);
        }

        $ads_script = Config::where([
            'meta' => 'script_ads'
        ])->first();

        if (!$ads_script) {
            Config::create([
                'meta' => 'script_ads',
                'value' => $request->ads_script ? $request->ads_script : ''
            ]);
        } else {
            $ads_script->update([
                'value' => $request->ads_script ? $request->ads_script : ''
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil memperbarui konfigurasi');
    }
}
