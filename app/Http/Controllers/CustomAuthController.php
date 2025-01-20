<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Etkinlikler;
use App\Models\Mesajlar;
use App\Models\Kullanicilar;
use App\Models\Katilimcilar;
use App\Models\Bildirimler;
use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\DB;
 use Carbon\Carbon;

class CustomAuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
       $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("login")->withErrors($validator);
    }



    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cinsiyet' => 'required'
        ]);
        
        $data = $request->all();
        $check = $this->create($data);
    
        $lastUser = User::where('email', $data['email'])->first();
    
        $post = new Kullanicilar;
        $post->kullanici_adi = $request->name;
        $post->dogum_tarihi = $request->birthdate;
        $post->ad = $request->name;
        $post->sifre = Hash::make($request->password);
        $post->soyad = $request->surname;
        $post->telefon_numarasi = $request->phone;
        $post->ilgi_alanlari = $request->ilgialanlari;
        $post->konum = $request->konum;
        $post->email = $request->email;
        $post->cinsiyet = $request->cinsiyet; 
        $post->user_id = $lastUser->id;  
    
        if (strpos($request->email, '@admin.com') !== false) {
            $post->is_admin = 1;
        } else {
            $post->is_admin = 0;
        }
        
        $post->save();
        
        return redirect("dashboard")->withSuccess('You have signed-in');
    }


    public function usercreate()
    {
        //if (Auth::check()) {
          //  if (Auth::user()->isadmin) {
        return view('admin.useradd');
            //}
        //}
    }

    public function userstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Kullanıcıyı users tablosuna ekle
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Kullanıcıyı kullanicilar tablosuna ekle
        DB::table('kullanicilar')->insert([
            'userid' => $user->id,
            'kullanici_adi' => $request->name,
            'soyad' => $request->soyad,
            'ilgi_alanlari' => $request->ilgi_alanlari,
            'cinsiyet' => $request->cinsiyet,
            'email' => $request->email,
            'is_admin' => 0
        ]);

        return redirect()->route('user.add')->with('success', 'Kullanıcı başarıyla eklendi!');
    }

    
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'isadmin' => strpos($data['email'], 'admin') !== false ? 1 : 0,
        ]);
    }
    
    public function dashboard()
    {
        if (Auth::check()) {
            if (Auth::user()->isadmin) {
                $etkinlikler = Etkinlikler::all();
                return view('admin.dashboard', compact('etkinlikler'));
            } else {
                $userid = Auth::user()->id;
                
                $katildigiEtkinliklerId = Katilimcilar::where('kullanici_id', $userid)
                                                ->pluck('etkinlik_id');
                $etkinlikler = Etkinlikler::whereIn('id', $katildigiEtkinliklerId)->get();
                $bildirimler = Bildirimler::where('user_id', $userid)->where('okundu', false)->get();
                 $katilimPuan = DB::table('katilimcilar') ->join('users', 'users.id', '=', 'katilimcilar.kullanici_id') 
                ->where('users.id', $userid) ->count() * 10;
                $olusturmaPuan = DB::table('etkinlikler')->where('kullanici_id', $userid)->count() * 15;
                $ilkKatilim = DB::table('katilimcilar') ->join('users', 'users.id', '=', 'katilimcilar.kullanici_id') ->where('users.id', $userid) ->exists();
                $bonusPuan = $ilkKatilim ? 20 : 0;
                $puan = $katilimPuan + $olusturmaPuan + $bonusPuan;
                
                return view('auth.dashboard', compact('etkinlikler', 'bildirimler', 'puan'));
            }
        }

        return redirect('login');
    }
public function markAsRead($id)
{
    if (Auth::check()) {
        $user = Auth::user();
        $bildirim = Bildirimler::where('id', $id)->where('user_id', $user->id)->first();

        if ($bildirim) {
            $bildirim->okundu = true;
            $bildirim->save();

            return redirect()->back()->with('success', 'Bildirim okundu olarak işaretlendi!');
        } else {
            return redirect()->back()->with('error', 'Bildirim bulunamadı.');
        }
    }

    return redirect('login')->with('error', 'Giriş yapmalısınız.');
}

    public function explore()
    {
        if (Auth::check()) {
            if (Auth::user()->isadmin) {
                $etkinlikler = Etkinlikler::all();
                return view('admin.dashboard', compact('etkinlikler'));
            } else {
                $userid = Auth::user()->id;
                $etkinlikler = Etkinlikler::all();
    
                $etkinlikler = $etkinlikler->map(function ($etkinlik) use ($userid) {
                    $etkinlik->katilimci_var_mi = Katilimcilar::where('etkinlik_id', $etkinlik->id)
                                                           ->where('kullanici_id', $userid)
                                                           ->exists();
                    return $etkinlik;
                });
    
                return view('auth.explore', compact('etkinlikler'));
            }
        }
    
        return redirect('login');
    }
    
        
    public function allusers()
    {
        if(Auth::check()){
            if(Auth::user()->isadmin){
                $users = User::all();

                return view('admin.allusers', compact('users'));
            } else {
                $etkinlikler = Etkinlikler::all();
                return view('auth.dashboard', compact('etkinlikler'));
            }
        }

    }

    public function etkinlikdetay($id)
    {
        if (Auth::check()) {
            $etkinlik = DB::table('etkinlikler')->where('id', $id)->first();
            $user_id = Auth::user()->id;
    
            $ilgiAlanlariString = DB::table('kullanicilar')->where('userid', $user_id)->value('ilgi_alanlari');
            $ilgiAlanlariArray = explode(',', $ilgiAlanlariString); 
    
            $ilgiliEtkinlikler = DB::table('etkinlikler')
                ->where(function($query) use ($ilgiAlanlariArray) {
                    foreach ($ilgiAlanlariArray as $ilgiAlani) {
                        $query->orWhere('kategori', 'like', '%' . trim($ilgiAlani) . '%');
                    }
                })
                ->where('id', '!=', $etkinlik->id)
                ->select('etkinlikler.*')
                ->distinct()
                ->take(5)
                ->get();
    
            return view('auth.etkinlik-detay', compact('etkinlik', 'ilgiliEtkinlikler'));
        }
        return redirect('login');
    }
    
    public function userdetay($id)
    {
        if(Auth::check()){
            $user = User::where('id', $id)->first();
            return view('admin.user-detay', compact('user'));
        }

    }

    public function eventadd()
    {
        if(Auth::check()){
            return view('auth.eventadd');
        }
    }

    public function eventonay($id)
    {
        $post = Etkinlikler::find($id); 
        $post->isonay = 1;
        $post->update();

        return redirect()->intended('dashboard')
        ->withSuccess('Signed in');
    }

    public function eventaddpost(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
    
            $post = new Etkinlikler;
            $post->etkinlik_adi = $request->etkinlik_adi;
            $post->aciklama = $request->aciklama;
            $post->konum = $request->konum;
            $post->tarih = $request->tarih;
            $post->saat = $request->saat;
            $post->etkinlik_suresi = $request->sure;
            $post->bitis_saati = $request->bitissaat;
            $post->kategori = $request->kategori;
            $post->kullanici_id = $user_id; 
            $post->save();
    
            DB::table('users')->where('id', $user_id)->increment('puan', 15);
    
            return redirect()->route('eventadd')->with('success', 'Etkinlik başarıyla oluşturuldu! 15 puan kazandınız.');
        }
    
        return redirect('login')->with('error', 'Giriş yapmalısınız.');
    }
    
    

    public function etkinliksil($id)
    {
            $user = Etkinlikler::find($id);
            $user->delete();
            $etkinlikler = Etkinlikler::all();
            return view('auth.dashboard', compact('etkinlikler'));
        
    }


    public function etkinlikkatil($etkinlik_id)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
    
            $katilmakIstediğiEtkinlik = DB::table('etkinlikler')->where('id', $etkinlik_id)->first();
    
            $bitis_saati = Carbon::parse($katilmakIstediğiEtkinlik->saat)->addMinutes($katilmakIstediğiEtkinlik->etkinlik_suresi);
    
            $cakisiyorMu = DB::table('katilimcilar')
                ->join('etkinlikler', 'katilimcilar.etkinlik_id', '=', 'etkinlikler.id')
                ->where('katilimcilar.kullanici_id', $user_id)
                ->where('etkinlikler.tarih', $katilmakIstediğiEtkinlik->tarih)
                ->where(function($query) use ($katilmakIstediğiEtkinlik, $bitis_saati) {
                    $query->whereBetween('etkinlikler.saat', [$katilmakIstediğiEtkinlik->saat, $bitis_saati])
                          ->orWhereBetween('etkinlikler.bitis_saati', [$katilmakIstediğiEtkinlik->saat, $bitis_saati])
                          ->orWhere(function($query) use ($katilmakIstediğiEtkinlik, $bitis_saati) {
                              $query->where('etkinlikler.saat', '<=', $katilmakIstediğiEtkinlik->saat)
                                    ->where('etkinlikler.bitis_saati', '>=', $bitis_saati);
                          });
                })
                ->exists();
    
            if ($cakisiyorMu) {
                return response()->json(['message' => 'Etkinlik zamanları çakışıyor.'], 409);
            }
    
            DB::table('katilimcilar')->insert([
                'kullanici_id' => $user_id,
                'etkinlik_id' => $etkinlik_id,
                'created_at' => now(),
            ]);
    
            $ilkKatilim = DB::table('katilimcilar')->where('kullanici_id', $user_id)->count() == 1;
            if ($ilkKatilim) {
                DB::table('users')->where('id', $user_id)->increment('puan', 20);
            } else {
                DB::table('users')->where('id', $user_id)->increment('puan', 10);
            }
    
            return redirect()->intended('dashboard')
            ->withSuccess('Signed in');
                }
    
        return redirect('login');
    }
    
    
    public function usersil($id)
    {
        $user = User::find($id);
        $user->delete();
        $users = User::all();
        return view('admin.allusers', compact('users'));
        
    }
    public function profileupdate(Request $request, $id)
    {
        // Kullanıcıyı belirtilen user_id ile bul
        $kullanici = Kullanicilar::where('userid', $id)->first();
    
        if ($kullanici) {
            // Kullanıcı bilgilerini güncelle
            $kullanici->ad = $request->input('ad'); 
            $kullanici->soyad = $request->input('soyad'); 
            $kullanici->email = $request->input('email'); 
            $kullanici->ilgi_alanlari = $request->input('ilgialanlari'); 
            $kullanici->cinsiyet = $request->input('cinsiyet'); 
            $kullanici->telefon_numarasi = $request->input('telefon_numarasi'); 
    
            // Güncellemeleri kaydet
            $kullanici->save();
    
            // Başarı mesajı ile yönlendirme
            return redirect()->route('profile.show', ['id' => $id])->with('success', 'Profil güncellendi!');
        } else {
            // Kullanıcı bulunamazsa hata mesajı göster
            return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
        }
    }
        public function profile($id)
    {
        if (Auth::user()->isadmin) {
            $kullanici = DB::table('kullanicilar')->where('userid', $id)->first();
            return view('admin.profile', compact('kullanici'));
        } else {
            $kullanici = DB::table('kullanicilar')->where('userid', $id)->first();
            return view('auth.profile', compact('kullanici'));
        }
        
    }

    public function chat($event_id = null)
{
    if (Auth::check()) {
        if (Auth::user()->isadmin) {
            $etkinlikler = Etkinlikler::all();
            $mesajlar = collect();

            if ($event_id) {
                $mesajlar = Mesajlar::where('etkinlikid', $event_id)->get();
            }

            return view('admin.chat', compact('mesajlar', 'etkinlikler', 'event_id'));
        } else {
            $userid = Auth::user()->id;

            $katildigiEtkinliklerId = Katilimcilar::where('kullanici_id', $userid)
                                                ->pluck('etkinlik_id');

            $etkinlikler = Etkinlikler::whereIn('id', $katildigiEtkinliklerId)->get();
            $mesajlar = collect();

            if ($event_id && $katildigiEtkinliklerId->contains($event_id)) {
                $mesajlar = Mesajlar::where('etkinlikid', $event_id)->get();
            }

            return view('auth.chat', compact('mesajlar', 'etkinlikler', 'event_id'));
        }
    }

    return redirect("login")->with('error', 'You are not allowed to access');
}

    


    public function sendmessage(Request $request)
    {
       
        $message = $request->input('message');
        $event_id = $request->input('event_id');
        Mesajlar::create([ 'mesaj_metni' => $message, 
        'gonderici_id' => Auth::user()->id,  
        'etkinlikid' => $event_id,
        'gonderim_zamani' => now()
        ]);
        $mesajlar = Mesajlar::all();
        $users = User::all();
        foreach ($users as $user) {
            Bildirimler::create([  
                'user_id' => $user->id,
            'content' => 'Yeni bir mesajınız var: ' . $message, 
            ]);
        }
        return back()->with('success', 'Mesaj gönderildi!', compact('mesajlar'));
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}