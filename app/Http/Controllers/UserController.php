<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        header('Content-type: image/png');
        $file_name='123.png';
        $colors=[''];
        $im = imagecreatetruecolor(128, 128);


        $white = imagecolorallocate($im,rand(100,255), rand(100,255), rand(100,255));
        imagefilledrectangle($im, 0, 0, 128, 128, $white);
        $grey = imagecolorallocate($im, 255, 255, 255);
        imagettftext($im,40,0,30,80,$grey,'arial.ttf','PO');
        imagepng($im,$file_name);
        $status=imagedestroy($im);

        $users=User::where(['status'=>1])->orderBy('id','desc')->get();
        return view('users.index',compact('users'));
    }

    public function list(Request $request)
    {
        if(request()->ajax()){
            $users=User::where(['status'=>1])->latest();
            $all_users=DataTables::of($users)
                ->editColumn('profile_picture',function(User $user){
                    return "<img src=".asset('uploads/users/'.$user->id.'/'.$user->profile_picture)." style='object-fit:cover;width:50px;border-radius:50%;'>";
                })
                ->editColumn('status', function(User $user) {
                    $value = $user->status;
                    $checked = $value == 1 || $value == 2 ? "checked" : "";
                    $status_label='';
                    if ($value == 1) {
                        $status_label = "Active";
                    }
                    if ($value == 2) {
                        $status_label = "InActive";
                    }
                    $status = "<div class=\"dropdown\"><button class=\"btn btn-secondary dropdown-toggle \" type=\"button\" id=\"dropdownStatus\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">$status_label</button><div class=\"dropdown-menu\" aria-labelledby=\"dropdownStatus\"><a class=\"dropdown-item update_status\" data-id=\"$user->id\" data-status=\"1\" href='javascript:void(0);'>Active</a><a class=\"dropdown-item update_status\" data-id=\"$user->id\" data-status=\"2\" href='javascript:void(0);'>Inactive</a></div></div>";
                    return [
                        'display' => $status,
                        'status' => $user->status
                    ];
                })
                ->addColumn('action', function(User $user) {
                    $action = "";
                    $action .= "<a  class=\"btn btn-theme btn-sm mx-2\"
                                    href=" .  "
                                    data-toggle=\"tooltip\"
                                    data-placement=\"top\" title=\"View User\">
                                    <i class='fa fa-eye'></i>
                                </a>";

                    $action .= "<a  class=\"btn btn-info btn-sm mx-2\"
                                    href=" . "
                                    data-toggle=\"tooltip\"
                                    data-placement=\"top\" title=\"Edit User\">
                                    <i class='fa fa-edit'></i>
                                </a>";
                    $action .= "<a class=\"btn btn-danger button_delete btn-sm tooltip-cls\" data-id=\"" . $user->id . "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Remove User\"  href=\"javascript:void(0);\" data-url=''><i class='fa fa-trash'></i></a>";
                    return $action;
                })
                ->escapeColumns([])
                ->make(true);
                // dd($all_users);
            return $all_users;
        }
    }

    public function store(Request $request)
    {
        // dd('ss');
        // try
        // {
            $file_name='';
            $user=new User;
            $user->title = $request->user_title;
            $user->name = $request->user_name;
            $user->email = $request->user_email;
            $user->password=bcrypt('password');
            // @mkdir($destinationPath, 0777, true);
            if(!empty($request->user_profile)){
                $image = request()->file('user_profile');
                $file_name = time() . "_" . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
                $user->profile_picture=$file_name;
            }
            $user->status = 1;
            $user->save();
            if(!empty($request->user_profile)){
                // $this->profile_create();
                $image = request()->file('user_profile');
                $file_name = time() . "_" . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users/'.$user->id);
                $image->move($destinationPath, $file_name);
            }
            else{
                $destinationPath = public_path('/uploads/users/'.$user->id);
                $file_name=time() . "_" . rand(0000, 9999) . '.png';
                @mkdir($destinationPath, 0777, true);
                $user_image=(new \Laravolt\Avatar\Avatar)->create($request->user_name)->setBackground('#001122')->save($destinationPath."/".$file_name,100);
                // dd($result);
                // if($image_name=$this->profile_create($user->id,$name)){
                    $user->profile_picture=$file_name;
                    $user->save();
                // }
            }

            // if($user->save()){

            //     return response()->json(['success'=>true,'msg'=>'Project added successfully']);
            // }
        // }
        // catch(Exception $ex)
        // {
        //     dd($ex->getMessage());
        // }
    }

    public function profile_create($id,$name)
    {
        header('Content-type: image/png');
        $file_name=time() . "_" . rand(0000, 9999) . '.png';
        $im = imagecreatetruecolor(128, 128);
        $white = imagecolorallocate($im,rand(100,255), rand(100,255), rand(100,255));
        imagefilledrectangle($im, 0, 0, 128, 128, $white);
        $grey = imagecolorallocate($im, 255, 255, 255);
        imagettftext($im,40,0,25,80,$grey,'arial.ttf',$name);
        imagepng($im,'uploads/users/'.$id.'/'.$file_name);

        $status=imagedestroy($im);
        if($status){
            return $file_name;
        }
    }

    public function userslist(Request $request)
    {
        $search = $request->search;

      if($search == ''){
         $users = User::orderby('name','asc')->select('id','name')->limit(5)->get();
      }else{
         $users = User::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->get();
      }
        $response = array();
        foreach($users as $employee){
            $response[] = array(
                "id"=>$employee->id,
                "text"=>$employee->name
            );
        }

        return response()->json($response);
    }
}
