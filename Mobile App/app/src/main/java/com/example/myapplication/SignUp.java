package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.myapplicationResponseModels.SignUpResponse;

import java.io.IOException;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SignUp extends AppCompatActivity {
    EditText fullName;
    EditText email;
    EditText password;
    EditText address;
    Button   signUp;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);
        fullName = (EditText) findViewById(R.id.customerName);
        email = (EditText) findViewById(R.id.customerEmail);
        password = (EditText) findViewById(R.id.CustomerPassword);
        address = (EditText) findViewById(R.id.CustomerAddress);
        signUp = (Button) findViewById(R.id.signUp_btn_SA);
        signUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                userSignUP();
            }
        });

    }

    public void userSignUP(){
        String name = fullName.getText().toString().trim().toLowerCase();
        String userEmail = email.getText().toString().trim().toLowerCase();
        String userAddress = address.getText().toString().trim().toLowerCase();
        String userPassword = password.getText().toString().trim().toLowerCase();

        Call<SignUpResponse> call = RetrofitClient
                    .getInstance()
                    .getAPi()
                    .addCustomer(name,userEmail,userPassword,userAddress);

        call.enqueue(new Callback<SignUpResponse>() {
            @Override
            public void onResponse(Call<SignUpResponse> call, Response<SignUpResponse> response) {


                    SignUpResponse signUpResponse = response.body();
                        if(response.isSuccessful()) {
                            Intent intent= new Intent(SignUp.this , Login_Customer.class);
                            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                            startActivity(intent);
                            Toast.makeText(SignUp.this, signUpResponse.getMessage() , Toast.LENGTH_LONG).show();
                            //Toast.makeText(SignUp.this, signUpResponse.getStatus(), Toast.LENGTH_LONG).show();
                        }
                        else {
                            Toast.makeText(SignUp.this, signUpResponse.getStatus(), Toast.LENGTH_LONG).show();
                        }



            }

            @Override
            public void onFailure(Call<SignUpResponse> call, Throwable t) {
                Toast.makeText(SignUp.this , t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });
    }


}