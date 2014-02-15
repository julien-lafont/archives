package models;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Table;

import net.sf.oval.constraint.NotNull;

import play.data.validation.Required;
import play.db.jpa.Model;

@Entity
@Table(name="appellation")
public class Appellation extends Model {

	@NotNull
	@Required
	@Column(unique=true)
	public String nom;

	@Override
	public String toString() {
		return nom;
	}

}
