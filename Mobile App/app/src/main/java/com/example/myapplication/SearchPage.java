package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.myapplicationResponseModels.SearchVendor;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SearchPage extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setContentView(R.layout.activity_search_page);
        super.onCreate(savedInstanceState);

        String ven_name = getIntent().getStringExtra("vendor_name");

        Call<SearchVendor> call = RetrofitClient
                .getInstance()
                .getAPi()
                .searchVendor(ven_name);
        call.enqueue(new Callback<SearchVendor>() {
            @Override
            public void onResponse(Call<SearchVendor> call, Response<SearchVendor> response) {
                SearchVendor searchVendor = response.body();

               if (response.isSuccessful()){

                   String[] names ;
                   String[] price ;
                   String[] status ;

                   names = new String[searchVendor.getResult().size()];
                   status = new String[searchVendor.getResult().size()];
                   price = new String[searchVendor.getResult().size()];

                   for (int i=0 ; i<searchVendor.getResult().size(); i++){

                       names[i]=searchVendor.getResult().get(i).getName();
                       price[i]=searchVendor.getResult().get(i).getPrice_per_litre()+ " PKR";
                       status[i]=searchVendor.getResult().get(i).getStatus();

                   }

                   RecyclerView recyclerView = findViewById(R.id.search_r_view);
                   recyclerView.setLayoutManager(new LinearLayoutManager(SearchPage.this));
                   recyclerView.setAdapter(new SearchAdapter(names,status,price));
               }
               else
               {
                   TextView textView;
                   textView = findViewById(R.id.searchStatus);
                   textView.setText("Record not exist");
               }


            }

            @Override
            public void onFailure(Call<SearchVendor> call, Throwable t) {
                Toast.makeText(SearchPage.this , t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });




//        String names[] = {"Hassan" , "Hassa" , "Hassa"};
//        String price[] = {"20 Per litre" , "30 Per Litre" , "30 Per Litre"};
//        String status[] = {"Open" , "Closed" , "Closed"};

    }
}