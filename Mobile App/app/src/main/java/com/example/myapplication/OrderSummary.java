package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.myapplicationResponseModels.PlaceOrderResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class OrderSummary extends AppCompatActivity {

    @Override

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_summary);
        String customer_id = getIntent().getStringExtra("customer_id");
        Button summary_btn ;
        summary_btn = findViewById(R.id.btn_summary);
        TextView lable1 , lable2 , lable3 , lable4, lable5 , total_amt;

        lable1 = findViewById(R.id.item1);
        lable2 = findViewById(R.id.item2);
        lable3 = findViewById(R.id.item3);
        lable4 = findViewById(R.id.item4);
        lable5 = findViewById(R.id.item5);
        total_amt = findViewById(R.id.total_amount);

        String[] names = getIntent().getStringArrayExtra("product_names");
        String[] qty = getIntent().getStringArrayExtra("product_quantity");
        String[] price = getIntent().getStringArrayExtra("product_price");
        String[] id = getIntent().getStringArrayExtra("product_id");

        String[][] products = new String[id.length][id.length];

       products[0][0] = id[0];
        products[0][1] = qty[0];
        products[1][0] = id[1];
        products[1][1] = qty[1];
        products[2][0] = id[2];
        products[2][1] = qty[2];

//
//
//
        int total_price = 2300;
////        int[] total = new int[price.length];
//        for(int i=0 ; i<price.length ; i++){
//            total_price +=  Integer.parseInt(price[i]);
////            total[i] = Integer.parseInt(price[i]) * Integer.parseInt(qty[i]);
//        }
//
//
//
//        for (int i=0 ; i<names.length ;i++){
//            lable1.setText((i+1) + "  " + names[i] + qty[i] + "  X " + price[i]);
//        }


        lable1.setText("1.  " + names[0] + "    "  + qty[0] + "  X " + price[0]);
        lable2.setText("2.  " + names[1] + "    "  + qty[1] + "  X " + price[1]);
        lable3.setText("3.  " + names[2] + "    "  + qty[2] + "  X " + price[2]);
        lable4.setText("");
        lable5.setText("");

//        if(names.length == 1){
//
//            lable1.setText("1.  " + names[0] + "    "  + qty[0] + "  X " + price[0]);
////            lable2.setText("2.  " + names[1] + "    "  + qty[1] + "  X " + price[1]);
////            lable3.setText("3.  " + names[2] + "    "  + qty[2] + "  X " + price[2]);
//            lable2.setText("");
//            lable3.setText("");
//            lable4.setText("");
//            lable5.setText("");
//        }
//        else if (names.length == 2){
//            lable1.setText("1.  " + names[0] + "    "  + qty[0] + "  X " + price[0]);
//            lable2.setText("2.  " + names[1] + "    "  + qty[1] + "  X " + price[1]);
//            lable3.setText("");
//            lable4.setText("");
//            lable5.setText("");
//        }
//        else if (names.length == 3){
//            lable1.setText("1.  " + names[0] + "    "  + qty[0] + "  X " + price[0]);
//            lable2.setText("2.  " + names[1] + "    "  + qty[1] + "  X " + price[1]);
//            lable3.setText("3.  " + names[2] + "    "  + qty[2] + "  X " + price[2]);
//            lable4.setText("");
//            lable5.setText("");
//        }
//        else if (names.length == 4){
//            lable1.setText("1.  " + names[0] + "    "  + qty[0] + "  X " + price[0]);
//            lable2.setText("2.  " + names[1] + "    "  + qty[1] + "  X " + price[1]);
//            lable3.setText("3.  " + names[2] + "    "  + qty[2] + "  X " + price[2]);
//            lable4.setText("4.  " + names[3] + "    "  + qty[3] + "  X " + price[3]);
//            lable5.setText("");
//        }
//        else if (names.length == 5){
//            lable1.setText("1.  " + names[0] + "    "  + qty[0] + "  X " + price[0]);
//            lable2.setText("2.  " + names[1] + "    "  + qty[1] + "  X " + price[1]);
//            lable3.setText("3.  " + names[2] + "    "  + qty[2] + "  X " + price[2]);
//            lable4.setText("4.  " + names[3] + "    "  + qty[3] + "  X " + price[3]);
//            lable5.setText("5.  " + names[4] + "    "  + qty[4] + "  X " + price[4]);
//        }
//        else
//        {
//            lable1.setText("");
//            lable2.setText("");
//            lable3.setText("");
//            lable4.setText("");
//            lable5.setText("");
//        }

        total_amt.setText(total_price  + "PKR");



        summary_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


//                String[][] products = {
//                        {"0" , "1"},
//                        {"4" , "8"}
//                };


                Call<PlaceOrderResponse> call = RetrofitClient
                        .getInstance()
                        .getAPi()
                        .placeOrder("15" , "20" , products ,"2300");

                call.enqueue(new Callback<PlaceOrderResponse>() {
                    @Override
                    public void onResponse(Call<PlaceOrderResponse> call, Response<PlaceOrderResponse> response) {
                        PlaceOrderResponse placeOrderResponse = response.body();
                        if (response.isSuccessful()){
                            Toast.makeText(getApplicationContext(),placeOrderResponse.getMessage() , Toast.LENGTH_LONG).show();
                        }

                        else {
                            Toast.makeText(getApplicationContext(),placeOrderResponse.getError() , Toast.LENGTH_LONG).show();
                        }
                    }

                    @Override
                    public void onFailure(Call<PlaceOrderResponse> call, Throwable t) {

                    }
                });



                Intent intent = new Intent(OrderSummary.this , OrderPlaced.class);

//                Toast.makeText(getApplicationContext(), names[0] , Toast.LENGTH_LONG).show();
                Toast.makeText(getApplicationContext(),"Order Placed Successfully!", Toast.LENGTH_LONG).show();
                startActivity(intent);
            }
        });
    }
}