<?php

namespace App\Http\Services\Repositories;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\Interfaces\IUser;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository implements IUser
{
    public function me()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => UserResource::make($user)
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => UserResource::make($user)
        ], Response::HTTP_OK);
    }

    public function update(ProfileUpdateRequest $request, $user_id)
    {
        $validate = Validator::make($request->all(), (new ProfileUpdateRequest())->rules());

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $avatarName);
            $avatarPath = '/storage/avatars/' . $avatarName;

            $user = auth('sanctum')->user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->dob = $request->dob;
            $user->avatar = $avatarPath;
            $user->age = Carbon::parse($request->dob)->age;
            $user->save();
        }

        $user = auth('sanctum')->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->age = Carbon::parse($request->dob)->age;
        $user->save();


        return response()->json([
            'success' => true,
            'data' => UserResource::make($user)
        ], Response::HTTP_OK);
    }

    public function destroy($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function updatePassword(PasswordUpdateRequest $request, $user_id)
    {
        $passwordValid = Validator::make($request->all(), (new PasswordUpdateRequest())->rules());

        if ($passwordValid->fails()) {
            return response()->json([
                'success' => false,
                'message' => $passwordValid->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ], Response::HTTP_OK);
    }

    public function addressAdd(AddressRequest $request)
    {
        $validate = Validator::make($request->all(), (new AddressRequest())->rules());

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = auth('sanctum')->user();

        //eğer eklenen yeni adres default == true ise diğer adreslerin default değerini false yap
        if ($request->default) {
            Address::where('user_id', $user->id)->update(['default' => false]);
        }

        $address = Address::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'default' => $request->default ? true : false,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
        ]);

        if ($request->default) {
            $user->address_id = $address->id;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully'
        ], Response::HTTP_OK);
    }

    public function addressUpdate(AddressRequest $request, $user_id, $address_id)
    {
        $validate = Validator::make($request->all(), (new AddressRequest())->rules());

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $address = Address::find($address_id)->where('user_id', $user_id)->first();
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $address->address = $request->address;
        $address->city_id = $request->city_id;
        $address->country_id = $request->country_id;
        $address->state_id = $request->state_id;

        if ($request->default) {
            Address::where('user_id', $user_id)->update(['default' => false]);
        }

        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully'
        ], Response::HTTP_OK);
    }
}
