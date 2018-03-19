package com.example.olivet.myapplication;

import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import java.util.ArrayList;

import static com.example.olivet.myapplication.JuryManager.KEY_LOGIN_;
import static com.example.olivet.myapplication.JuryManager.KEY_NUMJURY;
import static com.example.olivet.myapplication.JuryManager.KEY_PASSWORD_;

/**
 * Created by olivet on 21/12/17.
 */

public class Page_connexion extends Activity {

    static ArrayList<ArrayList<Integer>> listeGrpNote = Recuperation_Envoi.listeGrpNote;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.page_connexion);

        final EditText identifiant = (EditText)findViewById(R.id.EditTextIdentifiant);
        final EditText password = (EditText) findViewById(R.id.editTextMotDePasse);

        Button button = (Button)findViewById(R.id.button2);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Page_connexion.this,Planning.class);
                JuryManager juryMan = new JuryManager(view.getContext());
                juryMan.open();
                Cursor jurys = juryMan.getJurys();
                int id = 0;
                while (jurys.moveToNext()) {
                    if (jurys.getString(jurys.getColumnIndex(KEY_LOGIN_)).equals(identifiant.getText().toString()) && jurys.getString(jurys.getColumnIndex(KEY_PASSWORD_)).equals(password.getText().toString())) {
                        id = jurys.getInt(jurys.getColumnIndex(KEY_NUMJURY));
                    }
                }
                if(id==0){
                    Toast.makeText(getApplicationContext(),"Echec de l'authentification",Toast.LENGTH_LONG).show();
                    return;
                }
                jurys.close();
                juryMan.close();
                i.putExtra("NumJury", id);

                JugeManager jugeMan = new JugeManager(view.getContext());
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
/*
                DonneManager donMan = new DonneManager(view.getContext());
                donMan.open();
                Cursor donnes = donMan.getDonneNJNote();
                listeGrpNote = new ArrayList<ArrayList<Integer>>();
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
                        listeGrpNote.add(listeAux);
                    }
                }
                donnes.close();
                donMan.close();*/
                finish();
                startActivity(i);
            }
        });
    }
}
