package models;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Table;

import play.data.validation.Match;
import play.data.validation.Required;
import play.db.jpa.Model;

import net.sf.oval.constraint.NotBlank;
import net.sf.oval.constraint.NotNull;

@Entity
@Table(name="couleurvin")
public class CouleurVin extends Model {

	@NotNull
	@Required
	@Column(unique=true)
	public String nom;

	@Required
	@Match(message="La couleur doit être au format hexadécimal : #AABBCC", value="^#[0-9A-F]{6}$")
	public String code;

	public CouleurVin() {

	}

	public CouleurVin(String nom, String code) {
		this.nom = nom;
		this.code = code;
	}

	@Override
	public String toString() {
		return nom;
	}


}
