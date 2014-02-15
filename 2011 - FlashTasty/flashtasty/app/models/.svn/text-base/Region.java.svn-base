package models;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Table;

import net.sf.oval.constraint.NotNull;

import play.data.validation.Required;
import play.db.jpa.Model;

@Entity
@Table(name="region")
public class Region extends Model {

	@NotNull
	@Required
	@Column(unique=true)
	public String nom;


	public Region() {

	}

	public Region(String nom) {
		this.nom = nom;
	}

	@Override
	public String toString() {
		return nom;
	}
}
