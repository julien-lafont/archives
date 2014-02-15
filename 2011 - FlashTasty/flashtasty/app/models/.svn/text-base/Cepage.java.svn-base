package models;

import java.util.List;
import java.util.Set;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.ManyToMany;
import javax.persistence.Table;
import net.sf.oval.constraint.NotNull;
import play.data.validation.Required;
import play.db.jpa.Model;

@Entity
@Table(name="cepage")
public class Cepage extends Model {

	@NotNull
	@Required
	@Column(unique=true)
	public String nom;

	@ManyToMany(targetEntity=Vin.class, mappedBy="cepages")
	public List<Vin> vins;

	public Cepage() {

	}

	public Cepage(String nom) {
		this.nom = nom;
	}

	@Override
	public String toString() {
		return nom;
	}
}
