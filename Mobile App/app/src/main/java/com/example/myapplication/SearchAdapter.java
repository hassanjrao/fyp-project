package com.example.myapplication;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

public class SearchAdapter extends RecyclerView.Adapter<SearchAdapter.SeacrchViewHolder> {



    private String name[];
    private  String status[];
    private  String price[];

    public SearchAdapter(String name[] , String status[] , String price[]) {
        this.name = name;
        this.price=price;
        this.status = status;
    }

    @NonNull
    @Override
    public SeacrchViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.searchlayout , parent , false);
        return  new SearchAdapter.SeacrchViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull SeacrchViewHolder holder, int position) {
    String s_pr_name = name[position];
    String s_pr_status = status[position];
    String s_pr_price = price[position];

    holder.s_pro_name.setText(s_pr_name);
    holder.s_pro_status.setText(s_pr_status);
    holder.s_pro_price.setText(s_pr_price);
    }

    @Override
    public int getItemCount() {
        return name.length;
    }

    public class SeacrchViewHolder extends  RecyclerView.ViewHolder{
        TextView s_pro_name;
        TextView s_pro_status;
        TextView s_pro_price;

        public SeacrchViewHolder(@NonNull View itemView) {
            super(itemView);
            s_pro_name = itemView.findViewById(R.id.search_proName);
            s_pro_status = itemView.findViewById(R.id.search_status);
            s_pro_price = itemView.findViewById(R.id.search_price);

        }

    }
}
