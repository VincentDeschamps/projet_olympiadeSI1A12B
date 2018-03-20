package com.example.olivet.myapplication;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.database.MatrixCursor;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.RequiresApi;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;
import android.widget.SimpleCursorAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;


/**
 * Created by fdubois on 11/01/18.
 */

public class projet_desc extends Activity {

    ArrayList<ArrayList<Integer>> listeGrpNote = Page_connexion.listeGrpNote;

    @Override
    protected void onCreate(Bundle saveInstanceState){
        super.onCreate(saveInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.projet_desc);

        final int id = getIntent().getExtras().getInt("NumJury");
        final String NomProj = getIntent().getExtras().getString("NomProj");

        TextView tvNomProjet = (TextView) findViewById(R.id.textViewDescNomProjet);
        tvNomProjet.setText(tvNomProjet.getText().toString()+NomProj);

        TextView tvDescIdJury = (TextView) findViewById(R.id.textViewDescIdJury);
        tvDescIdJury.setText(tvDescIdJury.getText().toString()+id);

        Button buttonSupprNotes = (Button)findViewById(R.id.buttonSupprimer);
        buttonSupprNotes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                GroupeManager gpMan = new GroupeManager(view.getContext());
                gpMan.open();
                final int idGp = gpMan.getNumGroupe(NomProj);
                gpMan.close();



                new AlertDialog.Builder(view.getContext())
                        .setIcon(android.R.drawable.ic_dialog_alert)
                        .setTitle("Supprimer les notes")
                        .setMessage("Voulez-vous vraiment supprimer toutes les notes de ce projet?")
                        .setPositiveButton("Oui", new DialogInterface.OnClickListener()
                        {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                ArrayList<Integer> listeAux = new ArrayList<Integer>();
                                for (ArrayList<Integer> listeNote : listeGrpNote){
                                    if (idGp == listeNote.get(0)){
                                        listeAux = listeNote;
                                    }
                                }
                                listeGrpNote.remove(listeAux);

                                DonneManager donMan = new DonneManager(projet_desc.this);
                                donMan.open();
                                int idNote = -1;
                                Cursor c = donMan.getDonneIdNote(id, idGp);
                                if (c.moveToFirst()){
                                    idNote = c.getInt(c.getColumnIndex("idNote"));
                                }
                                Donne donne = new Donne(id, idGp, idNote);
                                donMan.supDonne(donne);
                                donMan.close();

                                NoteManager noteMan = new NoteManager(projet_desc.this);
                                noteMan.open();
                                Note note = new Note(idNote, -1, -1, -1, -1, -1, -1);
                                noteMan.addNote(note);
                                noteMan.close();

                                Intent i = new Intent(projet_desc.this,Planning.class);
                                i.putExtra("NumJury", getIntent().getExtras().getInt("NumJury"));
                                i.putExtra("nomProjet", getIntent().getExtras().getStringArrayList("nomProjet"));
                                i.putExtra("heureD", getIntent().getExtras().getStringArrayList("heureD"));
                                i.putExtra("heureF", getIntent().getExtras().getStringArrayList("heureF"));
                                i.putExtra("numSalle", getIntent().getExtras().getStringArrayList("numSalle"));
                                i.putExtra("NumGroupe", getIntent().getExtras().getIntegerArrayList("NumGroupe"));
                                finish();
                                startActivity(i);
                            }

                        })
                        .setNegativeButton("Non", null)
                        .show();
            }
        });

        Button buttonModifNotes = (Button)findViewById(R.id.buttonModifier);
        buttonModifNotes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                GroupeManager gpMan = new GroupeManager(view.getContext());
                gpMan.open();
                final int idGp = gpMan.getNumGroupe(NomProj);
                gpMan.close();

                Intent i = new Intent(projet_desc.this, AjoutNote.class);
                boolean trouve = false;

                for (ArrayList<Integer> listeNote : listeGrpNote){
                    if (idGp == listeNote.get(0)){
                        i.putExtra("listeNote", listeNote);
                        trouve = true;
                    }
                }

                if (!trouve){
                    ArrayList<Integer> listeNote = new ArrayList<Integer>();
                    for (int j = 0; j < 6; j++){
                        listeNote.add(null);
                    }
                    i.putExtra("listeNote", listeNote);
                }
                i.putExtra("NumJury", id);
                i.putExtra("NomProj", NomProj);
                i.putExtra("nomProjet", getIntent().getExtras().getStringArrayList("nomProjet"));
                i.putExtra("heureD", getIntent().getExtras().getStringArrayList("heureD"));
                i.putExtra("heureF", getIntent().getExtras().getStringArrayList("heureF"));
                i.putExtra("numSalle", getIntent().getExtras().getStringArrayList("numSalle"));
                i.putExtra("NumGroupe", getIntent().getExtras().getIntegerArrayList("NumGroupe"));
                startActivity(i);
            }
        });

        // Définition des colonnes
// NB : SimpleCursorAdapter a besoin obligatoirement d'un ID nommé "_id"
        String[] columns = new String[] { "_id", "col1", "col2" };

// Définition des données du tableau
// les lignes ci-dessous ont pour seul but de simuler
// un objet de type Cursor pour le passer au SimpleCursorAdapter.
// Si vos données sont issues d'une base SQLite,
// utilisez votre "cursor" au lieu du "matrixCursor"
        MatrixCursor matrixCursor= new MatrixCursor(columns);
        startManagingCursor(matrixCursor);
        matrixCursor.addRow(new Object[] { 1,"Prototype",getIntent().getExtras().getIntegerArrayList("listeNote").get(1)});
        matrixCursor.addRow(new Object[] { 2,"Originalité",getIntent().getExtras().getIntegerArrayList("listeNote").get(2) });
        matrixCursor.addRow(new Object[] { 3,"Démarche Scientifique",getIntent().getExtras().getIntegerArrayList("listeNote").get(3) });
        matrixCursor.addRow(new Object[] { 4,"Pluridisciplinarité",getIntent().getExtras().getIntegerArrayList("listeNote").get(4) });
        matrixCursor.addRow(new Object[] { 5,"Maîtrise Scientifique",getIntent().getExtras().getIntegerArrayList("listeNote").get(5) });
        matrixCursor.addRow(new Object[] { 6,"Communication",getIntent().getExtras().getIntegerArrayList("listeNote").get(6) });

// on prendra les données des colonnes 1 et 2...
        String[] from = new String[] {"col1", "col2"};

// ...pour les placer dans les TextView définis dans "row_item.xml"
        int[] to = new int[] { R.id.textViewProjCol1, R.id.textViewProjCol2};

// création de l'objet SimpleCursorAdapter...
        SimpleCursorAdapter adapter = new SimpleCursorAdapter(this, R.layout.row_item_note_projet, matrixCursor, from, to, 0){
            @RequiresApi(api = Build.VERSION_CODES.O)
            @Override
            public View getView(int position, View convertView, ViewGroup parent){
                // Get the current item from ListView
                View view = super.getView(position,convertView,parent);
                return view;
            }
        };

// ...qui va remplir l'objet ListView
        ListView lv = (ListView) findViewById(R.id.lv);
        lv.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                      @Override
                                      public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                                          switch(i) {
                                              case 0:
                                                  onClickOri(); break;
                                              case 1:
                                                  onClickProto(); break;
                                              case 2:
                                                  onClickDem(); break;
                                              case 3:
                                                  onClickPluri(); break;
                                              case 4:
                                                  onClickMait(); break;
                                              case 5:
                                                  onClickCom(); break;
                                          }
                                      }
                                  });
        lv.setAdapter(adapter);
    }

    public void onClickProto(){
        Toast.makeText(getApplicationContext(),"Le prototype est fonctionnel, innovant et le travail réalisé est conséquent",Toast.LENGTH_LONG).show();
    }

    public void onClickOri(){
        Toast.makeText(getApplicationContext(),"Le projet est original et innovant. « Vous seriez prêt à l’acquérir »",Toast.LENGTH_LONG).show();
    }

    public void onClickMait(){
        Toast.makeText(getApplicationContext(),"Le développement théorique est conséquent et bien maitrisé.",Toast.LENGTH_LONG).show();
    }

    public void onClickDem(){
        Toast.makeText(getApplicationContext(),"Le projet s’appui su des expérimentations, de la simulation théorique et numérique avec une comparaison entre le réel et le modèle et une optimisation.",Toast.LENGTH_LONG).show();
    }

    public void onClickPluri(){
        Toast.makeText(getApplicationContext(),"Le projet mobilise plusieurs discipline (SI, Math, Phy, …) et plusieurs technologies (Transfert d’énergie, traitement de l’information, mécanique, …)",Toast.LENGTH_LONG).show();
    }

    public void onClickCom(){
        Toast.makeText(getApplicationContext(),"La présentation est claire, structurée, dynamique. Elle valorise le travail d’équipe. Les réponses aux questions sont pertinentes.",Toast.LENGTH_LONG).show();
    }

    @Override
    public void onBackPressed(){
        Intent i = new Intent(projet_desc.this,Planning.class);
        i.putExtra("NumJury", getIntent().getExtras().getInt("NumJury"));
        i.putExtra("nomProjet", getIntent().getExtras().getStringArrayList("nomProjet"));
        i.putExtra("heureD", getIntent().getExtras().getStringArrayList("heureD"));
        i.putExtra("heureF", getIntent().getExtras().getStringArrayList("heureF"));
        i.putExtra("numSalle", getIntent().getExtras().getStringArrayList("numSalle"));
        i.putExtra("NumGroupe", getIntent().getExtras().getIntegerArrayList("NumGroupe"));
        finish();
        startActivity(i);
    }

    @Override
    public void onPause(){
        super.onPause();
        finish();

    }


}
