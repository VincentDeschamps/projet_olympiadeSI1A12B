package com.example.olivet.myapplication;

/**
 * Created by olivet on 16/01/18.
 */

public class Groupe {
    private int id_groupe;
    private String nom_projet;
    private String lycee;
    private String salle;
    private String image;

    Groupe(int id, String nom_projet, String lycee, String salle, String image){
        this.id_groupe=id;
        this.nom_projet=nom_projet;
        this.lycee=lycee;
        this.salle=salle;
        this.image=image;

    }

    public int getId_groupe() {
        return id_groupe;
    }

    public String getNom_projet() {
        return nom_projet;
    }


    public String getLycee() {
        return lycee;
    }

    public String getSalle() {
        return salle;
    }

    public String getImage() {
        return image;
    }

    public void setId_groupe(int id_groupe) {
        this.id_groupe = id_groupe;
    }

    public void setNom_projet(String nom_projet) {
        this.nom_projet = nom_projet;
    }

    public void setLycee(String lycee) {
        this.lycee = lycee;
    }

    public void setSalle(String salle) {
        this.salle = salle;
    }

    public void setImage(String image) {
        this.image = image;
    }
}
