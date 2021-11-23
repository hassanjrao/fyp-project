package com.example.myapplication;

import android.app.Application;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.cardview.widget.CardView;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplicationResponseModels.GetSingleVendor;
import com.example.myapplicationResponseModels.LoginResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class VendorDataAdaptor extends RecyclerView.Adapter<VendorDataAdaptor.VendorDataViewholder> {

    @NonNull
    private Context context;
    private String[] data;
    private String[] Address;
    private String[] status;
    private String[] id;
    private String[] reviews;
    private int[] images;


//    ViewVendors viewVendors = new ViewVendors();
    public  VendorDataAdaptor(Context context,String[] data  , String[] Address , String[] status, String[] id , String[] reviews, int[] images){
        this.data = data;
        this.Address = Address;
        this.status = status;
        this.context = context;
        this.id = id;
        this.reviews = reviews;
        this.images = images;

    }

    public VendorDataViewholder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.list_vendors , parent , false);
        return  new VendorDataViewholder(view);



    }

    @Override
    public void onBindViewHolder(@NonNull VendorDataViewholder holder, int position) {
        String title = data[position];
        String add = Address[position];
        String sta = status[position];
        String idV = id[position];
        String rev = reviews[position];
        int img = images[position];

        holder.txtName.setText(title);
        holder.txtAddress.setText(add);
        holder.txtstatus.setText(sta);
        holder.rev.setText(rev);
        holder.imageView.setImageResource(img);
        holder.parentLayout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


                Intent intent = new Intent(context , ViewSingleVendor.class);
                intent.putExtra("v_name", title);
                intent.putExtra("v_rating", rev);
                intent.putExtra("v_id", idV);
                intent.putExtra("v_address", add);
                intent.putExtra("v_status", sta);
                context.startActivity(intent);



            }
        });

    }

    @Override
    public int getItemCount() {
        return data.length;
    }

    public class VendorDataViewholder extends RecyclerView.ViewHolder {
        ImageView imageIcon;
        TextView txtName;
        TextView txtAddress;
        TextView txtstatus;
        LinearLayout parentLayout;
        TextView rev;
        ImageView imageView;
        public VendorDataViewholder(@NonNull View itemView) {

            super(itemView);
            imageIcon = itemView.findViewById(R.id.imageIcon);
            txtName = itemView.findViewById(R.id.ven_name);
            txtAddress = itemView.findViewById(R.id.ven_address);
            txtstatus = itemView.findViewById(R.id.ven_status);
            parentLayout = itemView.findViewById(R.id.vendorCardLayout);
            rev = itemView.findViewById(R.id.ven_rev);
            imageView = itemView.findViewById(R.id.imageIcon);



        }
    }

}
