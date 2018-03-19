package com.example.olivet.myapplication;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;

/**
 * Created by olivet on 16/01/18.
 */

public class GroupeManager {
    private static final String TABLE_NAME = "Groupe";
    public static final String KEY_ID_GROUPE="NumGroupe";
    public static final String KEY_NOMPROJ_GROUPE="NomProj";
    public static final String KEY_LYCEE_GROUPE="Lycee";
    public static final String KEY_SALLE_GROUPE="numSalle";
    public static final String KEY_IMAGE_GROUPE="Image";
    public static final String CREATE_TABLE_GROUPE = "CREATE TABLE IF NOT EXISTS "+TABLE_NAME+
            " (" +
            " "+KEY_ID_GROUPE+" INTEGER primary key," +
            " "+KEY_NOMPROJ_GROUPE+" TEXT," +
            " "+KEY_LYCEE_GROUPE+" TEXT," +
            " "+KEY_SALLE_GROUPE+" TEXT," +
            " "+KEY_IMAGE_GROUPE+" TEXT" +
            ");";
    private MySQLite maBaseSQLite; // notre gestionnaire du fichier SQLite
    private SQLiteDatabase db;

    public GroupeManager(Context context)
    {
        maBaseSQLite = MySQLite.getInstance(context);
    }

    public void open()
    {
        //on ouvre la table en lecture/écriture
        db = maBaseSQLite.getWritableDatabase();
    }

    public void close()
    {
        //on ferme l'accès à la BDD
        db.close();
    }

    public long addGroupe(Groupe groupe) {
        // Ajout d'un enregistrement dans la table

        ContentValues values = new ContentValues();
        values.put(KEY_NOMPROJ_GROUPE, groupe.getNom_projet());
        values.put(KEY_LYCEE_GROUPE, groupe.getLycee());
        values.put(KEY_SALLE_GROUPE, groupe.getSalle());
        values.put(KEY_IMAGE_GROUPE, groupe.getImage());

        // insert() retourne l'id du nouvel enregistrement inséré, ou -1 en cas d'erreur
        return db.insert(TABLE_NAME,null,values);
    }

    public Groupe getGroupe(int id) {
        // Retourne le groupe dont l'id est passé en paramètre

        Groupe a=new Groupe(0,new String(),new String(),new String(),new String());

        Cursor c = db.rawQuery("SELECT * FROM "+TABLE_NAME+" WHERE "+KEY_ID_GROUPE+"="+id, null);
        if (c.moveToFirst()) {
            a.setId_groupe(c.getInt(c.getColumnIndex(KEY_ID_GROUPE)));
            a.setNom_projet(c.getString(c.getColumnIndex(KEY_NOMPROJ_GROUPE)));
            a.setLycee(c.getString(c.getColumnIndex(KEY_LYCEE_GROUPE)));
            a.setSalle(c.getString(c.getColumnIndex(KEY_SALLE_GROUPE)));
            a.setImage(c.getString(c.getColumnIndex(KEY_IMAGE_GROUPE)));
            c.close();
        }

        return a;
    }

    public int getNumGroupe(String NomProj){
        Cursor c = db.rawQuery("SELECT "+KEY_ID_GROUPE+" FROM "+TABLE_NAME+" WHERE "+KEY_NOMPROJ_GROUPE+"='"+NomProj+"'", null);
        int res = 0;
        if (c.moveToFirst()){
            res = c.getInt(c.getColumnIndex(KEY_ID_GROUPE));
        }
        return res;
    }

    public Cursor getGroupes() {
        // sélection de tous les enregistrements de la table
        return db.rawQuery("SELECT * FROM "+TABLE_NAME, null);
    }

}
