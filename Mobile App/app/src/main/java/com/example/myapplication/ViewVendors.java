package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.example.myapplicationResponseModels.GetVendors;
import com.example.myapplicationResponseModels.SignUpResponse;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ViewVendors extends AppCompatActivity {

    CardView cardView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        String cus_id = getIntent().getStringExtra("customer_id");
        Intent intent = new Intent(getApplicationContext(), ViewSingleVendor.class);
        intent.putExtra("customer_id" , cus_id);
        super.onCreate(savedInstanceState);

        Call<GetVendors> call = RetrofitClient
                .getInstance()
                .getAPi()
                .getVendors();

        call.enqueue(new Callback<GetVendors>() {
            @Override
            public void onResponse(Call<GetVendors> call, Response<GetVendors> response) {
               GetVendors data = response.body();


               if (response.isSuccessful()){

//                  Toast.makeText(getApplicationContext(), data.getMessage(), Toast.LENGTH_LONG).show();
                   String[] names ;
                   names = new String[data.getResult().size()];
                   String[] address ;
                   address = new String[data.getResult().size()];
                   String[] status ;
                   status = new String[data.getResult().size()];
                   String[] id ;
                   String[] reviews = {"4.3 (145)" , "4.8 (256)" , "4.2 (300) "  , "4.8 (15)"};
                   int[] images = {R.drawable.waterbotlle, R.drawable.waterbotleshort , R.drawable.waterbotleshort , R.drawable.waterbotleshort};
                   id = new String[data.getResult().size()];
                   ;
                   for (int i=0 ; i<data.getResult().size(); i++){
                       names[i]=data.getResult().get(i).getName();
                       address[i]=data.getResult().get(i).getAddress();
                       status[i]= "Price/litre " + data.getResult().get(i).getPrice_per_litre();
                       id[i]=data.getResult().get(i).getId();
                   }

                   setContentView(R.layout.activity_view_vendors);
                   RecyclerView recyclerView = findViewById(R.id.rvVendors);
                   recyclerView.setLayoutManager(new LinearLayoutManager(ViewVendors.this));
                   recyclerView.setAdapter(new VendorDataAdaptor(ViewVendors.this , names,address,status,id,reviews , images));

                   }
               else {
                   Toast.makeText(getApplicationContext(), data.getStatus(), Toast.LENGTH_LONG).show();
               }


            }
            @Override
            public void onFailure(Call<GetVendors> call, Throwable t) {
                Toast.makeText(ViewVendors.this , t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });



    }
}