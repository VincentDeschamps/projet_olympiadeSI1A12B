package com.example.olivet.myapplication;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;

/**
 * Created by fdubois on 16/01/18.
 */

public class NoteManager {


    private static final String TABLE_NAME = "note";
    public static final String KEY_ID_NOTE="idNote";
    public static final String KEY_PROTOTYPE="prototype";
    public static final String KEY_ORIGINALITE="originalite";
    public static final String KEY_DEMARCHESI="demarcheSI";
    public static final String KEY_PLURIDISCIPLIANRITE="pluriDisciplinarite";
    public static final String KEY_MAITRISE="maitrise";
    public static final String KEY_DEVDURABLE="devDurable";
    public static final String CREATE_TABLE_NOTE = "CREATE TABLE IF NOT EXISTS "+TABLE_NAME+
            " (" +
            " "+KEY_ID_NOTE+" INTEGER primary key," +
            " "+KEY_PROTOTYPE+" INTEGER," +
            " "+KEY_ORIGINALITE+" INTEGER," +
            " "+KEY_DEMARCHESI+" INTEGER," +
            " "+KEY_PLURIDISCIPLIANRITE+" INTEGER," +
            " "+KEY_MAITRISE+" INTEGER," +
            " "+KEY_DEVDURABLE+" INTEGER" +
            ");";
    private MySQLite maBaseSQLite; // notre gestionnaire du fichier SQLite
    private SQLiteDatabase db;

    // Constructeur
    public NoteManager(Context context)
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

    public long addNote(Note note) {
        // Ajout d'un enregistrement dans la table

        ContentValues values = new ContentValues();
        values.put(KEY_ID_NOTE, note.getIdNote());
        values.put(KEY_PROTOTYPE, note.getPrototype());
        values.put(KEY_ORIGINALITE, note.getOriginalite());
        values.put(KEY_DEMARCHESI, note.getDemarcheSI());
        values.put(KEY_PLURIDISCIPLIANRITE, note.getPluriDisciplinarite());
        values.put(KEY_MAITRISE, note.getMaitrise());
        values.put(KEY_DEVDURABLE, note.getDevDurable());

        // insert() retourne l'id du nouvel enregistrement inséré, ou -1 en cas d'erreur
        return db.insert(TABLE_NAME,null,values);
    }

    public int modNote(Note note) {
        // modification d'un enregistrement
        // valeur de retour : (int) nombre de lignes affectées par la requête

        ContentValues values = new ContentValues();
        values.put(KEY_PROTOTYPE, note.getPrototype());
        values.put(KEY_ORIGINALITE, note.getOriginalite());
        values.put(KEY_DEMARCHESI, note.getDemarcheSI());
        values.put(KEY_PLURIDISCIPLIANRITE, note.getPluriDisciplinarite());
        values.put(KEY_MAITRISE, note.getMaitrise());
        values.put(KEY_DEVDURABLE, note.getDevDurable());

        String where = KEY_ID_NOTE+" = ?";
        String[] whereArgs = {note.getIdNote()+""};

        return db.update(TABLE_NAME, values, where, whereArgs);
    }

    public void modNoteHard(Note note) {
        this.supNote(note);
        this.addNote(note);
    }

    public int supNote(Note note) {
        // suppression d'un enregistrement
        // valeur de retour : (int) nombre de lignes affectées par la clause WHERE, 0 sinon

        String where = KEY_ID_NOTE+" = ?";
        String[] whereArgs = {note.getIdNote()+""};

        return db.delete(TABLE_NAME, where, whereArgs);
    }

    public Note getNote(int id) {
        // Retourne la note dont l'id est passé en paramètre

        Note n=new Note(0,0, 0, 0, 0, 0, 0);

        Cursor c = db.rawQuery("SELECT * FROM "+TABLE_NAME+" WHERE "+KEY_ID_NOTE+"="+id, null);
        if (c.moveToFirst()) {
            n.setIdNote(c.getInt(c.getColumnIndex(KEY_ID_NOTE)));
            n.setPrototype(c.getInt(c.getColumnIndex(KEY_PROTOTYPE)));
            n.setOriginalite(c.getInt(c.getColumnIndex(KEY_ORIGINALITE)));
            n.setDemarcheSI(c.getInt(c.getColumnIndex(KEY_DEMARCHESI)));
            n.setPluriDisciplinarite(c.getInt(c.getColumnIndex(KEY_PLURIDISCIPLIANRITE)));
            n.setMaitrise(c.getInt(c.getColumnIndex(KEY_MAITRISE)));
            n.setDevDurable(c.getInt(c.getColumnIndex(KEY_DEVDURABLE)));
            c.close();
        }
        return n;
    }

    public Cursor getNotes() {
        // sélection de tous les enregistrements de la table
        return db.rawQuery("SELECT * FROM "+TABLE_NAME, null);
    }

}