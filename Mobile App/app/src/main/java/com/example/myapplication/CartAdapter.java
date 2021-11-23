package com.example.myapplication;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

public class CartAdapter extends RecyclerView.Adapter<CartAdapter.CartViewHolder> {
    private  String[] product_name , product_price , product_quantity;
//    private int[] images ;


    public  CartAdapter(String[] pro_name , String[] pro_price  , String[] pro_quantity ){
        this.product_name = pro_name;
        this.product_price = pro_price;
        this.product_quantity = pro_quantity;
//        this.images = images;

    }

    @NonNull
    @Override
    public CartViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.listcartitems , parent , false);
        return  new CartAdapter.CartViewHolder(view);

    }

    @Override
    public void onBindViewHolder(@NonNull CartViewHolder holder, int position) {
        String pr_name = product_name[position];
        String pr_price = product_price[position];
        String pr_qty = product_quantity[position];
//        int img = images[position];

        holder.pro_name.setText(pr_name);
        holder.pro_price.setText(pr_price);
        holder.pro_qty.setText(pr_qty);
//        holder.imageViewIcon.setImageResource(img);
    }

    @Override
    public int getItemCount() {
        return product_name.length;
    }

    public class CartViewHolder extends RecyclerView.ViewHolder{
        TextView pro_name , pro_price , pro_qty;
        ImageView imageViewIcon;
        public CartViewHolder(@NonNull View itemView) {
            super(itemView);
            pro_name = itemView.findViewById(R.id.cart_proName);
            pro_qty = itemView.findViewById(R.id.cart_proQuantity);
            pro_price = itemView.findViewById(R.id.cart_proPrice);
//            imageViewIcon = itemView.findViewById(R.id.cart_proImage);
        }
    }
}

