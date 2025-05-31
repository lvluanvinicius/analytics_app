<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Services\Integration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->user();

        return inertia('Application/Profile/Index', [
            'profile' => $data,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        try {
            $data = $request->only(['username', 'password', 'email', 'name']);

            if (array_key_exists('password', $data)) {
                if ($data['password'] == null || $data['password'] == '') {
                    unset($data['password']);
                }
            }

            $integration = new Integration();

            $update = $integration->updateProfile($request->session()->get('token'), $data);

            if (isset($update['status_code']) && $update['status_code'] === 422) {
                return redirect()->back()->withErrors($update['errors'])->with([
                    'error' => $update['error'],
                ]);
            }

            if (isset($update['error'])) {
                return redirect()->back()->with([
                    'error' => $update['error'],
                ]);
            }

            if (isset($update['status_code']) && $update['status_code'] == 200) {
                return to_route('app.profile.index')->with([
                    'success' => $update,
                ]);
            }

            throw new \Exception('Houve um erro desconhecido durante sua solicitação, por favor, tente novamente mais tarde.');

        } catch (\Exception $error) {
            return redirect()->back()->with([
                'error' => $error->getMessage(),
            ]);
        }
    }
}
