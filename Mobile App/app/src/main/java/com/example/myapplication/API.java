package com.example.myapplication;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;

import com.example.myapplicationResponseModels.GetProducts;
import com.example.myapplicationResponseModels.GetSingleVendor;
import com.example.myapplicationResponseModels.GetVendors;
import com.example.myapplicationResponseModels.LoginResponse;
import com.example.myapplicationResponseModels.PlaceOrderResponse;
import com.example.myapplicationResponseModels.SearchVendor;
import com.example.myapplicationResponseModels.SignUpResponse;
import com.example.myapplicationResponseModels.UpdateResponse;

import java.util.List;

public interface API {
    @FormUrlEncoded
    @POST("addCustomerApi.php")
    Call<SignUpResponse> addCustomer(
            @Field("customer_name") String c_name,
            @Field("customer_email") String c_email,
            @Field("customer_password") String c_password,
            @Field("customer_address") String c_address
    );

    @FormUrlEncoded
    @POST("validateCustomerApi.php")
    Call<LoginResponse> validateCustomer(

            @Field("customer_email") String c_email,
            @Field("customer_password") String c_password

    );

    @FormUrlEncoded
    @POST("updateCustomerApi.php")
    Call<UpdateResponse> updateCustomer(
            @Field("customer_id") String c_id,
            @Field("customer_name") String c_name,
            @Field("customer_email") String c_email,
            @Field("customer_password") String c_password,
            @Field("customer_address") String c_address
    );


    @GET("getVendorsApi.php")
    Call<GetVendors> getVendors();



//    @GET("getSingleVendorApi.php")
//    Call<GetSingleVendor> getSingleVendor(
//            @Field("vendor_id") String v_id
//    );

    @GET("getVendorProductsApi.php")
    Call<GetProducts> getProducts(
            @Query("vendor_id") String v_id
    );

    @GET("searchVendorsApi.php")
    Call<SearchVendor> searchVendor(
            @Query("vendor_name") String ven_name
    );


    @FormUrlEncoded
    @POST("placeOrderApi.php")
    Call<PlaceOrderResponse> placeOrder(
            @Field("vendor_id") String v_id,
            @Field("customer_id") String c_id,
            @Field("products") String products[][],
            @Field("total_price") String total_price
    );

}
