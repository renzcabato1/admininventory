<?php

namespace App\Http\Controllers;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use RealRashid\SweetAlert\Facades\Alert;
class EmployeeController extends Controller
{
    //
    public function view_employees()
    {
        $employees = Employee::with('user')->get();

        // dd($employees);
    
        return view('employees',
        array(
            'employees' => $employees,
            'header' => "Employees",
        ));
    }
    public function generate_employees()
    {
              //employee API
            $client = new Client([
            'base_uri' => 'http://192.168.50.119:4200/HRAPI/public/',
            'cookies' => true,
            ]);
    
            $data = $client->request('POST', 'oauth/token', [
                'json' => [
                    'username' => 'rccabato@premiummegastructures.com',
                    'password' => 'P@ssw0rd',
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'rVI1kVh07yb4TBw8JiY8J32rmDniEQNQayf3sEyO',
                    ]
            ]);
    
            $response = json_decode((string) $data->getBody());
            $key = $response->access_token;
    
            $dataEmployee = $client->request('get', 'employees', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $key,
                        'Accept' => 'application/json'
                    ],
                ]);
            $responseEmployee = json_decode((string) $dataEmployee->getBody());
            $employeesHRIS = $responseEmployee->data;
            foreach($employeesHRIS as $employee)
            {
                if($employee->emailaddress != null)
                {
                $userData = User::where('email',$employee->emailaddress)->first();
                // dd($userData);
                if($userData != null)
                {
               
                    if($employee->emp_status != "Active")
                    {
                        $userData->password = "";
                        $userData->status = "Inactive";
                        $userData->save();

                        $employeeData = Employee::where('emp_code',$employee->badgeno)->first();
                        $employeeData->status = $employee->emp_status;
                        $employeeData->save();

                    }
                    else
                    {
                        $employeeData = Employee::where('emp_code',$employee->badgeno)->first();
                        $employeeData->first_name = $employee->firstname;
                        $employeeData->middle_name = $employee->middlename;
                        $employeeData->last_name = $employee->lastname;
                        $employeeData->name = $employee->firstname." ".$employee->middlename." ".$employee->lastname;
                        $employeeData->department = $employee->department;
                        $employeeData->position = $employee->position;
                        $employeeData->status = $employee->emp_status;
                        $employeeData->emp_type = $employee->emp_type;
                        $employeeData->save();
                    }
                }
                else
                {
                    $user = new User;
                    $user->name = $employee->firstname." ".$employee->middlename." ".$employee->lastname;
                    $user->email = $employee->emailaddress;
                    $user->password = bcrypt('123456');
                    if($employee->emp_status != "Active")
                    {
                        $user->status = "Inactive";
                    }
                    else
                    {
                        $user->status = "Active";
                    }
                    $user->role = "User";
                    $user->save();

                    $emp = new Employee;
                    $emp->user_id = $user->id;
                    $emp->emp_code = $employee->badgeno;
                    $emp->name = $user->name;
                    $emp->department = $employee->department;
                    $emp->position = $employee->position;
                    $emp->status = $employee->emp_status;
                    $emp->emp_type = $employee->emp_type;
                    $emp->save();

                }
            }
                

        }

        Alert::success('Successfully generated/sync.')->persistent('Dismiss');
        return back();
            
    }
}
