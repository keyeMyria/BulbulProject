package com.bulbulproject.bulbul.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.bulbulproject.bulbul.R;

public class AccuracyResult extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_accuracy_result);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        android.support.v7.app.ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
        }

        int displayWidth = getWindowManager().getDefaultDisplay().getWidth();

        String score_text = "Score: " + getIntent().getIntExtra("accuracy_score", 7);
        ((TextView) findViewById(R.id.accuracy_score)).setText(score_text);
        (findViewById(R.id.text_restart)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                restart_training();
            }
        });
        (findViewById(R.id.icon_restart)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                restart_training();
            }
        });
    }

    void restart_training() {
        Intent intent = new Intent(getApplicationContext(), CategorySelectorActivity.class);
        startActivity(intent);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                Intent intent = new Intent(AccuracyResult.this, MainActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
                startActivity(intent);
                finish();
                return true;

            default:
                return super.onOptionsItemSelected(item);
        }
    }

}
