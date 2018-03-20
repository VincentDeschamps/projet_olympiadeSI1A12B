package com.example.olivet.myapplication;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.database.Cursor;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.TextView;
import android.view.View.OnClickListener;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;

public class Envoi_Donnees extends Activity {

    TextView textProgress;
    private ProgressDialog m_ProgressDialog;
    private AccessServiceAPI m_ServiceAccess;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.envoi_donnees);
        m_ServiceAccess=new AccessServiceAPI();

        textProgress = (TextView) findViewById(R.id.textProgress);
        new TaskEnvoi().execute();

    }

    public class TaskEnvoi extends AsyncTask<String,Void,Integer>{
        @Override
        public void onPreExecute(){
            super.onPreExecute();

            m_ProgressDialog= ProgressDialog.show(Envoi_Donnees.this,"Veuillez patienter ...","En cours de chargement",true);
        }
        @Override
        public Integer doInBackground(String...params){
            NoteManager noteManager=new NoteManager(getApplicationContext());
            DonneManager donneManager=new DonneManager(getApplicationContext());

            JSONObject dico_des_donnees= new JSONObject();
            noteManager.open();
            Cursor cursornote=noteManager.getNotes();
            JSONArray listeNotes=new JSONArray();
            while(cursornote.moveToNext()){
                JSONObject note=new JSONObject();
                try {
                    note.put("idNote",cursornote.getInt(cursornote.getColumnIndex("idNote")));
                    note.put("prototype",cursornote.getInt(cursornote.getColumnIndex("prototype")));
                    note.put("originalite",cursornote.getInt(cursornote.getColumnIndex("originalite")));
                    note.put("demarcheSI",cursornote.getInt(cursornote.getColumnIndex("demarcheSI")));
                    note.put("pluriDisciplinarite",cursornote.getInt(cursornote.getColumnIndex("pluriDisciplinarite")));
                    note.put("maitrise",cursornote.getInt(cursornote.getColumnIndex("maitrise")));
                    note.put("devDurable",cursornote.getInt(cursornote.getColumnIndex("devDurable")));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                listeNotes.put(note);
            }
            try {
                dico_des_donnees.put("Note",listeNotes);
            } catch (JSONException e) {
                e.printStackTrace();
            }
            cursornote.close();

            donneManager.open();
            Cursor cursordonne=donneManager.getDonnes();
            JSONArray listeDonne=new JSONArray();
            while(cursordonne.moveToNext()){
                JSONObject donne=new JSONObject();
                try {
                    donne.put("NumJury",cursordonne.getInt(cursordonne.getColumnIndex("NumJury")));
                    donne.put("NumGroupe",cursordonne.getInt(cursordonne.getColumnIndex("NumGroupe")));
                    donne.put("idNote",cursordonne.getInt(cursordonne.getColumnIndex("idNote")));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                listeDonne.put(donne);
            }
            try {
                dico_des_donnees.put("Donne",listeDonne);
            } catch (JSONException e) {
                e.printStackTrace();
            }
            cursordonne.close();

            JSONObject jObjResult;
            HashMap<String,String> data=new HashMap<String,String>();
            data.put("data",dico_des_donnees.toString());
            try {
                jObjResult = m_ServiceAccess.convertJSONString2Obj(m_ServiceAccess.getJSONStringWithParam_POST(Donnees_BD.ENVOI_URL, data));
                return jObjResult.getInt("resultat");
            } catch (Exception e){
                e.printStackTrace();
                return Donnees_BD.RESULT_ERROR;
            }


        }
        @Override
        public void onPostExecute(Integer res){
            super.onPostExecute(res);
            m_ProgressDialog.dismiss();

            if (Donnees_BD.RESULT_SUCCESS==res){
                Toast.makeText(getApplicationContext(), "Données envoyés", Toast.LENGTH_LONG).show();

                MainActivity.mainActivity.finish();
                Intent i=new Intent(getApplicationContext(),MainActivity.class);
                startActivity(i);
                finish();
            }
            else{
                Toast.makeText(getApplicationContext(),"Echec de l'envoi des données", Toast.LENGTH_LONG).show();

                MainActivity.mainActivity.finish();
                Intent i=new Intent(getApplicationContext(),MainActivity.class);
                startActivity(i);
                finish();
            }

        }
    }
}
