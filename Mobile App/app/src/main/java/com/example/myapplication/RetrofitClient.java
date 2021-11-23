package com.example.myapplication;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import retrofit2.Retrofit;

import retrofit2.converter.gson.GsonConverterFactory;;

public class RetrofitClient {

    private  static  final  String BASE_URL = "http://192.168.235.19/FYPUpdated/fyp-project/apis/";

    private static  RetrofitClient mInstance;
    private Retrofit retrofit;


    Gson gson = new GsonBuilder()
            .setLenient()
            .create();
    private RetrofitClient(){
        retrofit = new Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
    }

    public static synchronized  RetrofitClient getInstance(){
        if (mInstance == null){
            mInstance = new RetrofitClient();
        }
        return mInstance;
    }

    public  API getAPi(){
        return retrofit.create(API.class);
    }

}
