<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $updateFields = [];
    private $redirectRoute = 'profile.edit';
    private $successMessage = 'profile-updated';

    /**
     * Cria um novo builder para configuração da atualização de perfil.
     *
     * @return static
     */
    public static function builder(): self
    {
        return new self();
    }

    /**
     * Define quais campos serão atualizados no perfil.
     *
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->updateFields = $fields;
        return $this;
    }

    /**
     * Define a rota de redirecionamento após a atualização.
     *
     * @param string $route
     * @return $this
     */
    public function redirect(string $route): self
    {
        $this->redirectRoute = $route;
        return $this;
    }

    /**
     * Define a mensagem de sucesso após a atualização.
     *
     * @param string $message
     * @return $this
     */
    public function successMessage(string $message): self
    {
        $this->successMessage = $message;
        return $this;
    }

    /**
     * Atualiza o perfil do usuário com base nas configurações definidas.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'sometimes|required|email',
            'name' => 'sometimes|required|string|max:255',
        ]);

        $user = $request->user();
        foreach ($this->updateFields as $field) {
            if ($request->has($field)) {
                $user->$field = $request->input($field);
            }
        }

        if (in_array('email', $this->updateFields) && $user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route($this->redirectRoute)->with('status', $this->successMessage);
    }

    /**
     * Exibe o formulário de edição do perfil.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Deleta a conta do usuário.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}