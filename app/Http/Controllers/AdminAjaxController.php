<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Room;
use App\Models\RoomBooked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\RateLimiter;
use App\Mail\Email;
use Carbon\Carbon;
// use Elibyy\TCPDF\Facades\TCPDF;
use PDF;

class AdminAjaxController extends Controller
{
  public function index(Request $request)
  {
    // $password = '123';
    // Admin::create([
    //   'first_name' => 'Mardods',
    //   'last_name' => 'Da Greate',
    //   'username' => 'MardodsGwapo',
    //   'email' => 'pagalnella321@gmail.com',
    //   'password' => bcrypt($password),
    // ]);
    // return response()->json(['message' => 'success']);
    try {
      $this->CheckAttempt();
      $email = request('email');
      $password = request('password');

      $admin = Admin::where('email', $email)->first();

      if ($admin && Hash::check($password, $admin->password)) {
        $user = Auth::guard('admin')->user();

        if ($admin->email_verified_at) {
          Auth::guard('admin')->login($admin);

          session([
            'adminName' => $admin->first_name . ' ' . $admin->last_name,
            'adminId' => $admin->id,
            'admin_email' => $admin->email,
          ]);
          RateLimiter::clear($this->throttleKey());
          return response()->json(['message' => 'success']);
        } else {
          return response()->json(['message' => 'notverified']);
        }
      } else {
        RateLimiter::hit($this->throttleKey());
        return response()->json(['message' => 'failed']);
      }
    } catch (\Throwable $e) {
      return response()->json(['message' => 'max_attempt', 'time' => $e->getMessage()]);
    }
  }

  public function CheckAttempt()
  {
    $seconds = RateLimiter::availableIn($this->throttleKey());
    if (RateLimiter::tooManyAttempts($this->throttleKey(), 2)) {
      throw new Exception(gmdate($seconds), 494);
    }
  }

  public function throttleKey()
  {
    return Str::lower(request('email') . '|' . request()->ip());
  }

  public function google_handler(Request $request)
  {
    $gemail = request('email');
    $user = Admin::where('email', $gemail)->first();
    if ($user) {
      if ($user->email_verified_at) {
        Auth::guard('admin')->login($user);
        session([
          'adminName' => $user->first_name . ' ' . $user->last_name,
          'adminId' => $user->id,
          'admin_email' => $user->email,
        ]);
        return response()->json(['message' => 'success']);
      } else {
        return response()->json(['message' => 'notverified']);
      }
    } else {
      return response()->json(['message' => 'errror']);
    }
  }

  public function admin_logout()
  {
    Auth::guard('admin')->logout();
    request()
      ->session()
      ->invalidate();
    request()
      ->session()
      ->regenerateToken();
    return response()->json(['message' => 'success']);
  }

  public function update_admin_prof(Request $request)
  {
    $id = session('adminId');
    $username = $request->admin_username;
    $first_name = $request->admin_fname;
    $last_name = $request->admin_lname;
    $email = $request->admin_email;

    $new_admin = Admin::where('id', $id)->update([
      'first_name' => $first_name,
      'last_name' => $last_name,
      'username' => $username,
      'email' => $email,
    ]);

    if ($new_admin) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function change_pass(Request $request)
  {
    $id = session('adminId');

    $admin = Admin::where('id', $id)->first();

    $old_pass = $admin->password;
    $input_old_pass = $request->admin_oldpass;
    $new_pass = $request->admin_new_pass;
    $retype = $request->admin_retypepass;

    if (!Hash::check($input_old_pass, $old_pass)) {
      return response()->json(['message' => 'inavlid_old_pass']);
    } else {
      if ($new_pass != $retype) {
        return response()->json(['message' => 'passnot_the_same']);
      } else {
        $update_pass = Admin::where('id', $id)->update([
          'password' => bcrypt($new_pass),
        ]);
        return response()->json(['message' => 'success']);
      }
    }
  }

  public function admin_send_otp()
  {
    $randomOtp = random_int(100000, 999999);
    $toEmail = session('admin_email');
    $subject = 'One Time Pin';
    $content = $randomOtp;
    try {
      Mail::to($toEmail)->send(new Email($subject, $content, $toEmail));

      session(['admin_otp' => $randomOtp]);
      return response()->json(['message' => 'success']);
    } catch (Exception $e) {
      return response()->json(['message' => 'failed']);
    }
  }

  public function admin_confirm_otp(Request $request)
  {
    $input_otp = $request->forgot_otp;
    $new_pass = $request->forgot_new_pass;
    $retype = $request->forgot_retype_pass;
    $adminId = session('adminId');

    if ($input_otp != session('admin_otp')) {
      return response()->json(['message' => 'ivalid_otp']);
    }

    if ($new_pass !== $retype) {
      return response()->json(['message' => 'not_match']);
    }

    $update_pass = Admin::where('id', $adminId)->update([
      'password' => bcrypt($new_pass),
    ]);

    if ($update_pass) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function reports()
  {
    $rooms = Room::leftJoin('bookings', 'rooms.id', '=', 'bookings.room_id')
      ->where('bookings.status', '=', 'Checked Out')
      ->select('rooms.*', \DB::raw('SUM(bookings.total_amount) as total_amount'))
      ->groupBy('rooms.id')
      ->get();
    // $aminities = Facility::all();
    // $feature = Feature::all();
    // $total_room = Room::all();
    // $room_type = Category::all();

    return view('Admin.__div_list.reports', compact('rooms'));
  }

  public function filter_report(Request $request)
  {
    $from = $request->from;
    $end = $request->end;

    $rooms = Room::leftJoin('bookings', 'rooms.id', '=', 'bookings.room_id')
      ->where('bookings.check_in', '<=', $end)
      ->where('bookings.check_out', '>=', $from)
      ->where('bookings.status', '=', 'Checked Out')
      ->select('rooms.*', \DB::raw('SUM(bookings.total_amount) as total_amount'))
      ->groupBy('rooms.id')
      ->get();

    if ($rooms) {
      return response()->json(['message' => 'success', 'data' => $rooms]);
    }
  }

  public function download_report(Request $request)
  {
    $from = $request->get('from');
    $end = $request->get('end');
    $startDate = Carbon::parse($from);
    $endDate = Carbon::parse($end);
    $numberOfDays = $endDate->diffInDays($startDate);

    $rooms = Room::leftJoin('bookings', 'rooms.id', '=', 'bookings.room_id')
      ->where('bookings.check_in', '<=', $end)
      ->where('bookings.check_out', '>=', $from)
      ->where('bookings.status', '=', 'Checked Out')
      ->select('rooms.*', \DB::raw('SUM(bookings.total_amount) as total_amount'))
      ->groupBy('rooms.id')
      ->get();

    $filename = 'hotel_report.pdf';
    $html = view('Admin.report-format', compact('rooms', 'from', 'end', 'numberOfDays'))->render();

    // $html = '<h1 style="color:red;">Hello World</h1>';

    PDF::SetTitle('Hello World');
    PDF::AddPage();
    PDF::writeHTML($html, true, false, true, false, '');
    PDF::SetFont('dejavusans', '', 12);

    PDF::Output(public_path($filename), 'F');
    return response()->download(public_path($filename));
  }
}
