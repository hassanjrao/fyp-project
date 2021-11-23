package com.example.myapplicationResponseModels;

import com.google.gson.annotations.SerializedName;

public class SignUpResponse {

    String error;

    String status;
    String message;

    public SignUpResponse(String error, String status, String message) {
        this.error = error;
        this.status = status;
        this.message = message;
    }

    public String getError() {
        return error;
    }

    public String getStatus() {
        return status;
    }

    public String getMessage() {
        return message;
    }

    public void setError(String error) {
        this.error = error;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
