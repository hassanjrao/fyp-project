package com.example.myapplication;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import android.Manifest;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.myapplicationResponseModels.LoginResponse;
import com.example.myapplicationResponseModels.SignUpResponse;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;

import java.io.IOException;
import java.util.List;
import java.util.Locale;
import java.util.concurrent.ExecutionException;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class Login_Customer extends AppCompatActivity {

    private EditText email, password;
    private Button Login;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login__customer);



        email = (EditText) findViewById(R.id.txt_login);
        password = (EditText) findViewById(R.id.txt_Password);
        Login = (Button) findViewById(R.id.btn_signIn);
        Login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                userSignIn();
            }
        });
    }


    private void userSignIn() {


        String userEmail = email.getText().toString().trim().toLowerCase();
        String userPass = password.getText().toString().trim().toLowerCase();

        Call<LoginResponse> call = RetrofitClient
                .getInstance()
                .getAPi()
                .validateCustomer(userEmail, userPass);

        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {


                try {
                    LoginResponse loginResponse = response.body();
                    if (response.isSuccessful()) {
                        Intent intent = new Intent(Login_Customer.this, MainPage.class);
                        intent.putExtra("customer_id", loginResponse.getResult().get(0).getId());
                        intent.putExtra("customer_name", loginResponse.getResult().get(0).getName());
                        intent.putExtra("customer_password", loginResponse.getResult().get(0).getPassword());
                        intent.putExtra("customer_address", loginResponse.getResult().get(0).getAddress());
                        intent.putExtra("customer_email", loginResponse.getResult().get(0).getEmail());

                        //Get permission for location


                        //end location code


                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        startActivity(intent);
                        Toast.makeText(Login_Customer.this, loginResponse.getMessage(), Toast.LENGTH_LONG).show();
                    }
                } catch (Exception e) {
                    AlertDialog.Builder builder = new AlertDialog.Builder(Login_Customer.this);
                    builder.setMessage("User name or password is wrong")
                            .setPositiveButton("Try again", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialogInterface, int i) {
                                    Intent intent = new Intent(getApplicationContext(), Login_Customer.class);
                                    startActivity(intent);
                                }
                            });

                    AlertDialog alert = builder.create();
                    alert.show();
                }


            }


            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                Toast.makeText(Login_Customer.this, t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });

    }



}