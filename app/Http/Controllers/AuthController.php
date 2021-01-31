<?php

namespace App\Http\Controllers;

use App\Mail\userVerification;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{

    private $path;
    private $dimen;

    public function __construct()
    {
        $this->path = public_path().'/img/user/';
        $this->dimen = 750;
    }

    public function signup(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->email_code = Str::random(5);
            $user->level = $request->level;
            $user->save();
            if($request->level == 'client') {
                $client = new Client();
                $client->name = $user->name;
                $client->email = $user->email;
                $client->user_id = $user->id;
                $client->save();
            }
            return $this->onSuccess('Pendaftaran', $user, 'Berhasil');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->level = $request->level;
            if($request->level != 'client') {
                $client = Client::where('user_id', $user->id)->first();
                $client->delete();
            }
            return $this->onSuccess('User', $user, 'Berhasil diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            unlink($this->path.$user->avatar);
            if($user->level == 'client') {
                $client = Client::where('user_id', $user->id)->first();
                $client->delete();
            }
            $user->delete();
            return $this->onSuccess('User', $user, 'Berhasil dihapus');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show()
    {
        $auth = Auth::user();
        $user = User::with('Product', 'Auction', 'History', 'Client')->where('id', $auth->id)->first();
        return $this->onSuccess('User', $user, 'Authenticated');
    }

    public function upload(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if($user->avatar != 'avatar.png' || $user->avatar != null) {
                unlink($this->path.$user->avatar);
            }
            $avatar = $request->file('avatar');
            if($request->hasFile('avatar') && $request->file('avatar') != null) {
                if(!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path, 0777, false);
                }
                $avatarName = 'Avatar'.'_'.str_replace(' ', '_', $request->name).time().'.'.$avatar->extension();
                $img = Image::make($avatar->path());
                $img->resize($this->dimen, $this->dimen, function($constraint) {
                    $constraint->aspectRatio();
                })->save($this->path.$avatarName);
                $user->avatar = $avatarName;
            } else {
                $user->avatar = 'avatar.png';
            }
            $user->save();
            return $this->onSuccess('Upload Avatar', $user, 'Berhasil');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function verify($id)
    {
        try {
            $user = User::find($id);
            $txt = [
                'email' => $user->email,
                'name' => $user->name,
                'code' => $user->email_code,
            ];
            Mail::to($user->email)->send(new userVerification($txt));
            return $this->onSuccess('Verifikasi', $user, 'Email terkirim');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function signin(Request $request)
    {
        try {
            if(Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $success['token'] = $user->createToken('nApp')->accessToken;
                return $this->onSuccess('Login', [$user, $success], 'Berhasil');
            } else {
                return $this->onSuccess('Login', null, 'Gagal');
            }
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
