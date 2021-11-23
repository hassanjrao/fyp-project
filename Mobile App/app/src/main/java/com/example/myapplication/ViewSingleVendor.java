package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.myapplicationResponseModels.GetSingleVendor;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ViewSingleVendor extends AppCompatActivity {
    Button viewProducts;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_single_vendor);



        String name, status , address , id, rating ;
        TextView Vendor_name, Vendor_status , Vendor_address , vendor_rating;
        name = getIntent().getStringExtra("v_name");
        status = getIntent().getStringExtra("v_status");
        address = getIntent().getStringExtra("v_address");
        id = getIntent().getStringExtra("v_id");
        rating= getIntent().getStringExtra("v_rating");
        String cus_id = getIntent().getStringExtra("customer_id");


        Vendor_name = findViewById(R.id.singleVendorName);
        Vendor_status = findViewById(R.id.singleVendorStatus);
        Vendor_address = findViewById(R.id.singleVendorAddress);
        vendor_rating = findViewById(R.id.singleVendorRating);


        Vendor_status.setText(status);
        Vendor_name.setText(name);
        Vendor_address.setText(address);
        vendor_rating.setText(rating);


    viewProducts = findViewById(R.id.btnViewProducts);
    viewProducts.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View view) {
            Intent intent = new Intent(ViewSingleVendor.this, ViewProducts.class);
            intent.putExtra("v_id" , id);
            intent.putExtra("customer_id" , cus_id);
            startActivity(intent);
        }
    });
    }


}