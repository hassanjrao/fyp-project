package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;

import com.example.myapplicationResponseModels.GetProducts;
import com.example.myapplicationResponseModels.GetVendors;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ViewProducts extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setContentView(R.layout.activity_view_products);
        ImageView imageView;
        ImageView previousImage;

        previousImage = findViewById(R.id.image_back);

        previousImage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(ViewProducts.this, ViewSingleVendor.class);
                startActivity(intent);
            }
        });
        imageView = findViewById(R.id.cartButton);
        imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(ViewProducts.this, viewCart.class);
                //String vendor_id , customer_id;
                //vendor_id = getIntent().getStringExtra("v_id");
//                customer_id = getIntent().getStringExtra("customer_id");
               // intent.putExtra("v_id" , vendor_id);
//                intent.putExtra("customer_id",customer_id);
                startActivity(intent);
            }
        });




        super.onCreate(savedInstanceState);
        String vendor_id;
//        setContentView(R.layout.activity_view_products);
        vendor_id = getIntent().getStringExtra("v_id");

//        RecyclerView recyclerView = findViewById(R.id.viewProductsLayout);
//        String[] names  = {"hello"};
//        recyclerView.setLayoutManager(new LinearLayoutManager(ViewProducts.this));
//        recyclerView.setAdapter(new ProductAdapter(names));
//        Toast.makeText(ViewProducts.this , vendor_id, Toast.LENGTH_LONG).show();
//
        Call<GetProducts> call = RetrofitClient
                .getInstance()
                .getAPi()
                .getProducts(vendor_id);

        call.enqueue(new Callback<GetProducts>() {
            @Override
            public void onResponse(Call<GetProducts> call, Response<GetProducts> response) {
                GetProducts getProducts = response.body();

                if(response.isSuccessful()){
                    Toast.makeText(ViewProducts.this , getProducts.getMessage(), Toast.LENGTH_LONG).show();

                    String[] names ;
                    String[] price ;
                    String[] volume ;
                    String[] id;
                    int[] images = {R.drawable.waterbotleshort, R.drawable.waterbotlle, R.drawable.waterbotleshort, R.drawable.waterpicss  , R.drawable.productpic , R.drawable.waterbottle};
                    names = new String[getProducts.getResult().size()];
                    price = new String[getProducts.getResult().size()];
                    volume = new String[getProducts.getResult().size()];
                    id = new String[getProducts.getResult().size()];
                    for (int i=0 ; i<getProducts.getResult().size(); i++){

                        names[i]=getProducts.getResult().get(i).getProduct_name();
                        price[i]=getProducts.getResult().get(i).getPrice();
                        volume[i]=getProducts.getResult().get(i).getLiter()+ "Litre(s)";
                        id[i] = getProducts.getResult().get(i).getId();

                    }

                    RecyclerView recyclerView = findViewById(R.id.viewProductsLayout);
                    recyclerView.setLayoutManager(new LinearLayoutManager(ViewProducts.this));
                    recyclerView.setAdapter(new ProductAdapter(names,price,volume,id,images));



                }
                else
                {
                    Toast.makeText(ViewProducts.this , getProducts.getMessage(), Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onFailure(Call<GetProducts> call, Throwable t) {
                Toast.makeText(ViewProducts.this , t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });



    }
}