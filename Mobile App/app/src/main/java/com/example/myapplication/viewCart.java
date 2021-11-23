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

public class viewCart extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
//        ImageView pre_image;
//        pre_image = findViewById(R.id.image_back_cart);
//        pre_image.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent intent = new Intent(viewCart.this, ViewProducts.class);
//                startActivity(intent);
//            }
//        });


//        String[] names = {"Small" , "Family", "Regular" , "Jumbo" };
//        String[] qty = {"2", "1" , "2", "3" , "2" };
//        String[] price = {"20", "50" , "120", "260"  };

        String[] names = getIntent().getStringArrayExtra("product_names");
        String[] qty = getIntent().getStringArrayExtra("product_quantity");
        String[] price = getIntent().getStringArrayExtra("product_price");
        String[] id = getIntent().getStringArrayExtra("product_id");









//        int[] images = {R.drawable.waterbotleshort, R.drawable.waterbotlle, R.drawable.waterbotleshort , R.drawable.waterbottle};

        setContentView(R.layout.activity_view_cart);
        RecyclerView recyclerView = findViewById(R.id.cartRView);
        recyclerView.setLayoutManager(new LinearLayoutManager(viewCart.this));
        recyclerView.setAdapter(new CartAdapter(names,price,qty));


        Button check_out ;
        check_out = findViewById(R.id.btn_checkout);
        check_out.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(viewCart.this , OrderSummary.class);
                intent.putExtra("product_names" , names);
                intent.putExtra("product_price" , price);
                intent.putExtra("product_id" , id);
                intent.putExtra("product_quantity" , qty);
                startActivity(intent);
            }
        });




    }
}