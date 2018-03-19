package com.example.olivet.myapplication;


import android.app.Activity;
import android.app.Application;
import android.app.ProgressDialog;
import android.content.Intent;
import android.database.Cursor;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import static com.example.olivet.myapplication.JuryManager.KEY_LOGIN_;
import static com.example.olivet.myapplication.JuryManager.KEY_NUMJURY;
import static com.example.olivet.myapplication.JuryManager.KEY_PASSWORD_;

/**
 * Created by olivet on 17/01/18.
 */

public class Recuperation_Envoi extends Activity{
    private EditText txtUsername;
    private EditText txtPassword;
    private Button buttonCo;
    private AccessServiceAPI m_ServiceAccess;
    private ProgressDialog m_ProgressDialog;
    static ArrayList<ArrayList<Integer>> listeGrpNote = new ArrayList<ArrayList<Integer>>();


    @Override
    public void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.page_connexion);
        txtUsername=(EditText) findViewById(R.id.EditTextIdentifiant);
        txtPassword=(EditText) findViewById(R.id.editTextMotDePasse);
        m_ServiceAccess=new AccessServiceAPI();
        buttonCo= findViewById(R.id.button2);
        buttonCo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                btnLog(view);
            }
        });
    }

    public void btnLog(View v){
        if("".equals(txtUsername.getText().toString())){
            txtUsername.setError("Identifiant requis");
            return;
        }
        if("".equals(txtPassword.getText().toString())){
            txtPassword.setError("Mot de passe requis");
            return;
        }
        /* TODO AsyncTask a appeler */
        new TaskLogin().execute(txtUsername.getText().toString(),txtPassword.getText().toString());
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data){
        super.onActivityResult(requestCode, resultCode, data);
        if(resultCode==1){
            txtUsername.setText(data.getStringExtra("username"));
            txtPassword.setText(data.getStringExtra("password"));
        }
    }

    public class TaskLogin extends AsyncTask<String, Void, Integer>{
        @Override
        public void onPreExecute(){
            super.onPreExecute();

            m_ProgressDialog=ProgressDialog.show(Recuperation_Envoi.this,"Veuillez patienter ...","En cours de chargement",true);
        }

        @Override
        public Integer doInBackground(String...params){
            Map<String, String> param=new HashMap<>();
            param.put("action","login");
            param.put("username",params[0]);
            param.put("password",params[1]);


            JSONObject jObjResult;
            try {

                jObjResult = m_ServiceAccess.convertJSONString2Obj(m_ServiceAccess.getJSONStringWithParam_POST(Donnees_BD.SERVICE_API_URL, param));
                //Ajout des données dans la base de donnée locale

                JuryManager juryManager=new JuryManager(getApplicationContext());
                juryManager.open();
                JSONObject jurydonnees=(JSONObject) jObjResult.get("Jury");
                Jury jury=new Jury(jurydonnees.getInt("id"),jurydonnees.getString("Login"),jurydonnees.getString("pwd"));
                juryManager.addJury(jury);
                juryManager.close();

                HeureManager heureManager=new HeureManager(getApplicationContext());
                heureManager.open();
                JSONArray heuredonnees=(JSONArray) jObjResult.get("Heures");
                for(int i=0;i<heuredonnees.length();i++){
                    Heure heure=new Heure(heuredonnees.getJSONObject(i).getInt("idHeure"),heuredonnees.getJSONObject(i).getString("hDeb"),heuredonnees.getJSONObject(i).getString("hFin"));
                    heureManager.addHeure(heure);
                }
                heureManager.close();

                GroupeManager groupeManager=new GroupeManager(getApplicationContext());
                groupeManager.open();
                JSONArray groupedonnees=(JSONArray) jObjResult.get("Groupe");
                for(int i=0;i<groupedonnees.length();i++){
                    JSONObject groupeD=groupedonnees.getJSONObject(i);
                    Groupe groupe=new Groupe(groupeD.getInt("NumGroupe"),groupeD.getString("NomProj"),groupeD.getString("Lycee"),groupeD.getString("numSalle"),groupeD.getString("image_Projet"));
                    groupeManager.addGroupe(groupe);
                }
                groupeManager.close();

                JugeManager jugeManager=new JugeManager(getApplicationContext());
                jugeManager.open();
                JSONArray jugedonnees=(JSONArray) jObjResult.get("relation");
                for(int i=0;i<jugedonnees.length();i++){
                    JSONObject jugeD=jugedonnees.getJSONObject(i);
                    Juge juge=new Juge(jugeD.getInt("NumJury"),jugeD.getInt("NumGroupe"),jugeD.getInt("idHeure"));
                    jugeManager.addJuge(juge);
                }
                jugeManager.close();



                return jObjResult.getInt("result");
            } catch (Exception e) {
                e.printStackTrace();
                return Donnees_BD.RESULT_ERROR;
            }
        }

        @Override
        public void onPostExecute(Integer res){
            super.onPostExecute(res);
            m_ProgressDialog.dismiss();

            if (Donnees_BD.RESULT_SUCCESS==res){
                Toast.makeText(getApplicationContext(), "Authentification réussie", Toast.LENGTH_LONG).show();

                Intent i = new Intent(getApplicationContext(),Planning.class);
                JuryManager juryMan = new JuryManager(getApplicationContext());
                juryMan.open();
                Cursor jurys = juryMan.getJurys();
                int id = 0;
                while (jurys.moveToNext()) {
                    if (jurys.getString(jurys.getColumnIndex(KEY_LOGIN_)).equals(txtUsername.getText().toString()) && jurys.getString(jurys.getColumnIndex(KEY_PASSWORD_)).equals(txtPassword.getText().toString()) ) {
                        id = jurys.getInt(jurys.getColumnIndex(KEY_NUMJURY));
                    }
                }
                jurys.close();
                juryMan.close();
                i.putExtra("NumJury", id);

                JugeManager jugeMan = new JugeManager(getApplicationContext());
                jugeMan.open();
                Cursor juges = jugeMan.getNaturalJoinJuge();
                ArrayList<String> nomProjet = new ArrayList<String>();
                ArrayList<String> heureD = new ArrayList<String>();
                ArrayList<String> heureF = new ArrayList<String>();
                ArrayList<Integer> numGrp = new ArrayList<Integer>();
                ArrayList<String> numSalles = new ArrayList<String>();

                while (juges.moveToNext()) {
                    if (juges.getString(juges.getColumnIndex(KEY_NUMJURY)).equals(id+"")){
                        nomProjet.add(juges.getString(juges.getColumnIndex("NomProj")));
                        heureD.add(juges.getString(juges.getColumnIndex("hDeb")));
                        heureF.add(juges.getString(juges.getColumnIndex("hFin")));
                        numGrp.add(juges.getInt(juges.getColumnIndex("NumGroupe")));
                        numSalles.add(juges.getString(juges.getColumnIndex("numSalle")));
                    }
                }
                juges.close();
                jugeMan.close();
                i.putExtra("nomProjet", nomProjet);
                i.putExtra("heureD", heureD);
                i.putExtra("heureF", heureF);
                i.putExtra("NumGroupe", numGrp);
                i.putExtra("numSalle", numSalles);

                DonneManager donMan = new DonneManager(getApplicationContext());
                donMan.open();
                Cursor donnes = donMan.getDonneNJNote();
                while (donnes.moveToNext()){
                    if (donnes.getString(donnes.getColumnIndex(KEY_NUMJURY)).equals(id+"")) {
                        ArrayList<Integer> listeAux = new ArrayList<Integer>();
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("NumGroupe")));
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("prototype")));
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("originalite")));
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("demarcheSI")));
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("pluriDisciplinarite")));
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("maitrise")));
                        listeAux.add(donnes.getInt(donnes.getColumnIndex("devDurable")));
                    }
                }
                donnes.close();
                donMan.close();
                finish();
                startActivity(i);
            }
            else{
                Toast.makeText(getApplicationContext(),"Echec de l'authentification", Toast.LENGTH_LONG).show();
            }

        }

    }

}
