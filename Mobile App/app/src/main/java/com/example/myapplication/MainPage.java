package com.example.myapplication;
import androidx.annotation.NonNull;
import androidx.appcompat.widget.Toolbar;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Build;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.Gravity;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;


import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.navigation.NavigationView;

import java.io.IOException;
import java.util.List;
import java.util.Locale;

public class MainPage extends AppCompatActivity {
    NavigationView navigationView;
    ActionBarDrawerToggle actionBarDrawerToggle;
    DrawerLayout drawerLayout;
    Button viewVendor;
    Button search;
    String cus_id, cus_name, cus_pass, cus_email,cus_add;
    FusedLocationProviderClient fusedLocationProviderClient;
    String current_location;
    Double longitude,latitude;
    EditText search_text;


    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        //search button
        Intent intent2 = new Intent(MainPage.this , OrderSummary.class);
        intent2.putExtra("customer_id" , "23");
        //
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_page2);
        fusedLocationProviderClient = LocationServices.getFusedLocationProviderClient(this);

       cus_name = getIntent().getStringExtra("customer_name");
        cus_id = getIntent().getStringExtra("customer_id");
        cus_add = getIntent().getStringExtra("customer_address");
        cus_pass= getIntent().getStringExtra("customer_password");
        cus_email = getIntent().getStringExtra("customer_email");




        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        navigationView = (NavigationView)findViewById(R.id.navmenu);
        drawerLayout = (DrawerLayout) findViewById(R.id.drawer);

        actionBarDrawerToggle = new ActionBarDrawerToggle(this, drawerLayout,toolbar, R.string.open , R.string.close);
        drawerLayout.addDrawerListener(actionBarDrawerToggle);
        actionBarDrawerToggle.syncState();






        navigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem menuItem) {


                switch (menuItem.getItemId()){
                    case R.id.menu_update:
                        openActivityUpdate();
                        drawerLayout.closeDrawer(GravityCompat.START);
                        break;
                    case R.id.menu_logout:
                        drawerLayout.closeDrawer(GravityCompat.START);
                        Intent intent = new Intent(MainPage.this , Login_Customer.class);
                        startActivity(intent);
                        break;

                    case R.id.menu_mylocation:
                        Toast.makeText(getApplicationContext(), "Your Current Location is " + current_location  , Toast.LENGTH_LONG).show();
                        drawerLayout.closeDrawer(GravityCompat.START);
                        break;
                    case R.id.menu_helpCenter:
                        Toast.makeText(getApplicationContext(), "This page is not available yet", Toast.LENGTH_LONG).show();
                        drawerLayout.closeDrawer(GravityCompat.START);
                        break;
                }
                return true;
            }
        });

        viewVendor = findViewById(R.id.vVendor);
        viewVendor.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                viewVendors();
            }
        });

        search = findViewById(R.id.searchButton);
        search.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                search_text = findViewById(R.id.searchText);
                String s_text = search_text.getText().toString().toLowerCase();

                Intent intent = new Intent(MainPage.this , SearchPage.class);
                intent.putExtra("vendor_name" , s_text);
                startActivity(intent);
            }
        });






    }

    public void viewVendors(){

        if (ActivityCompat.checkSelfPermission(getApplicationContext(), Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED) {
//            Toast.makeText(getApplicationContext(),"I am Clicked!", Toast.LENGTH_LONG).show();
            getLocation();
//            Toast.makeText(getApplicationContext(),"I am Clicked!", Toast.LENGTH_LONG).show();
            Intent intent = new Intent(MainPage.this , ViewVendors.class);

            startActivity(intent);

        } else {
            ActivityCompat.requestPermissions(MainPage.this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 44);
        }


    }

    public void openActivityUpdate(){
        Intent intent = new Intent(this , UpdateProfile.class);
        intent.putExtra("c_name" , cus_name);
        intent.putExtra("c_address" , cus_add);
        intent.putExtra("c_id" , cus_id);
        intent.putExtra("c_email" , cus_email);
        intent.putExtra("c_pass" , cus_pass);
        startActivity(intent);
    }

    private void getLocation() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions

            return;
        }
        fusedLocationProviderClient.getLastLocation().addOnCompleteListener(new OnCompleteListener<Location>() {
            @Override
            public void onComplete(@NonNull Task<Location> task) {
                Location location = task.getResult();
                if (location != null) {

                    try {
                        Geocoder geocoder = new Geocoder(MainPage.this, Locale.getDefault());
                        List<Address> addresses = geocoder.getFromLocation(location.getLatitude(), location.getLongitude(), 1);
                        current_location = addresses.get(0).getLocality();
                        longitude = addresses.get(0).getLongitude();
                        latitude = addresses.get(0).getLatitude();

                        System.out.println("Long" + longitude);
                        System.out.println("Lati" + latitude);

                    } catch (IOException e) {
                        e.printStackTrace();
                    }


                }
            }
        });
    }
}