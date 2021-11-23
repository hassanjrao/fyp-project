package com.example.myapplication;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton;

import org.w3c.dom.Text;

public class ProductAdapter extends RecyclerView.Adapter<ProductAdapter.ProductViewHolder>  {




    private Context context;
//    private OnItemClickListner mListener;
    private  String[] pro_name , pro_vol ,  pro_price , pro_id ;
    private  int[] images ;


    private String counter ;
    String[] price = new String[5];
    String[] quantity = new String[5];
    String[] id= new String[5];
    String[] name = new String[5];
    private int i=0;

//    public  interface  OnItemClickListner{
//        void onItemClick();
//    }
//    public  void setOnItemClickListener(OnItemClickListner listener){
//        mListener = listener;
//    }

    public ProductAdapter(String[] pro_name , String[] pro_vol  , String[] pro_price , String[] pro_id, int[] images  ) {
        this.pro_name = pro_name;
        this.pro_price = pro_price;
        this.pro_vol = pro_vol;
        this.images = images;
        this.pro_id = pro_id;
    }

    @NonNull
    @Override
    public ProductViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.listproducts , parent , false);
        context = parent.getContext();
        return  new ProductAdapter.ProductViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ProductViewHolder holder, int position) {
        String pr_name = pro_name[position];
        String pr_price = pro_price[position];
        String pr_vol = pro_vol[position];
        String pr_id = pro_id[position];
        int img = images[position];
        holder.p_volume.setText(pr_vol);
        holder.p_price.setText(pr_price);
        holder.p_name.setText(pr_name);
        holder.imageViewPIcon.setImageResource(img);
        holder.elegantNumberButton.setOnValueChangeListener(new ElegantNumberButton.OnValueChangeListener() {
            @Override
            public void onValueChange(ElegantNumberButton view, int oldValue, int newValue) {
                counter = holder.elegantNumberButton.getNumber();

            }
        });

        holder.btn_addCart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                price[i] = pr_vol;
                quantity[i] = counter;
                id[i] = pr_id;
                name[i] = pr_name;

                Toast.makeText(context, " " + counter + " Items added successfully", Toast.LENGTH_LONG).show();

//                Toast.makeText(context, " " + counter + " Items added successfully" + " : " + quantity[i] + " : " + price[i] +  " : "+ id[i]  , Toast.LENGTH_LONG).show();
                i++;

//                SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
//                SharedPreferences.Editor editor = sharedPreferences.edit();
//                editor.putS("product_names" , name);
//                editor.commit();


//                context.startActivity(intent);

//                Toast.makeText(context, " " + counter + " Items added successfully", Toast.LENGTH_LONG).show();
            }
        });

        holder.imageViewPIcon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, viewCart.class);
                intent.putExtra("product_names" , name);
                intent.putExtra("product_price" , price);
                intent.putExtra("product_id" , id);
                intent.putExtra("product_quantity" , quantity);
                context.startActivity(intent);
            }
        });


//        holder.linearLayout_product.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent intent = new Intent(context,viewCart.class);
//                intent.putExtra("p_id"   , pr_id );
//                intent.putExtra("p_price" , pr_price);
//                intent.putExtra("p_name" , pr_name);
//                intent.putExtra("p_volume" , pr_vol);
//            }
//        });




    }


    @Override
    public int getItemCount() {
        return pro_name.length;
    }

    public class ProductViewHolder extends RecyclerView.ViewHolder{
    TextView p_name, p_volume , p_price ;
    Button btn_addCart;
    ElegantNumberButton elegantNumberButton;
    ImageView imageViewPIcon;
//    LinearLayout linearLayout_product;
        public ProductViewHolder(@NonNull View itemView) {
            super(itemView);

            p_name = itemView.findViewById(R.id.productName);
            p_price = itemView.findViewById(R.id.productPrice);
            p_volume = itemView.findViewById(R.id.productVolume);
            btn_addCart = itemView.findViewById(R.id.btn_addCart);
            elegantNumberButton = itemView.findViewById(R.id.quantity);
            imageViewPIcon = itemView.findViewById(R.id.productIcon);

//            linearLayout_product = itemView.findViewById(R.id.listProductsView);

        }
    }


}
