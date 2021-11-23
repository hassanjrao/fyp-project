package com.example.myapplication;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.myapplicationResponseModels.SignUpResponse;
import com.example.myapplicationResponseModels.UpdateResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UpdateProfile extends AppCompatActivity {

    EditText user_id;
    EditText fullName;
    EditText email;
    EditText password;
    EditText address;
    Button update;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_profile);
        user_id = (EditText) findViewById(R.id.txt_userID);
        fullName = (EditText) findViewById(R.id.txt_upName);
        email = (EditText) findViewById(R.id.txt_UpEmail);
        password = (EditText) findViewById(R.id.txt_upPass);
        address = (EditText) findViewById(R.id.txt_UpAddress);
        update = (Button) findViewById(R.id.btn_update);
        update.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                AlertDialog.Builder builder = new AlertDialog.Builder(UpdateProfile.this);
                builder.setMessage("Are you sure?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialogInterface, int i) {
                                userUpdate();
                                Intent intent = new Intent(UpdateProfile.this ,MainActivity.class);
                                startActivity(intent);
                            }
                        })
                        .setNegativeButton("Cancel",null);
                AlertDialog alert = builder.create();
                alert.show();

            }
        });

        user_id.setText(getIntent().getStringExtra("c_id"));
        fullName.setText(getIntent().getStringExtra("c_name"));
        email.setText(getIntent().getStringExtra("c_email"));
        password.setText(getIntent().getStringExtra("c_pass"));
        address.setText(getIntent().getStringExtra("c_address"));

    }

    public void userUpdate(){
        String u_id = user_id.getText().toString().trim().toLowerCase();
        String name = fullName.getText().toString().trim().toLowerCase();
        String userEmail = email.getText().toString().trim().toLowerCase();
        String userAddress = address.getText().toString().trim().toLowerCase();
        String userPassword = password.getText().toString().trim().toLowerCase();

        Call<UpdateResponse> call = RetrofitClient
                .getInstance()
                .getAPi()
                .updateCustomer(u_id,name,userEmail,userPassword,userAddress);

        call.enqueue(new Callback<UpdateResponse>() {
            @Override
            public void onResponse(Call<UpdateResponse> call, Response<UpdateResponse> response) {
                UpdateResponse updateResponse = response.body();
                if (response.isSuccessful()){
                    Toast.makeText(UpdateProfile.this, updateResponse.getMessage() , Toast.LENGTH_LONG).show();

                }
                else {
                    Toast.makeText(UpdateProfile.this, updateResponse.getStatus() , Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onFailure(Call<UpdateResponse> call, Throwable t) {
                Toast.makeText(UpdateProfile.this, t.getMessage() , Toast.LENGTH_LONG).show();
            }
        });
    }
}