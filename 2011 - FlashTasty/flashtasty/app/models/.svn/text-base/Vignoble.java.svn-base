package models;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.ManyToOne;
import javax.persistence.Table;

import net.sf.oval.constraint.NotNull;

import play.data.validation.Required;
import play.db.jpa.Model;

@Entity
@Table(name="vignoble")
public class Vignoble extends Model {

	@NotNull
	@Required
	@Column(unique = true)
	public String nom;

	@NotNull
	@Required
	@ManyToOne(fetch=FetchType.LAZY)
	public Region region;

	@Override
	public String toString() {
		return nom;
	}
}
