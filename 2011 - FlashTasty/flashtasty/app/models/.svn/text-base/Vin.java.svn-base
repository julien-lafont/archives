package models;

import java.util.List;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Lob;
import javax.persistence.ManyToMany;
import javax.persistence.ManyToOne;
import javax.persistence.Table;

import net.sf.oval.constraint.NotNull;
import play.data.validation.MaxSize;
import play.data.validation.Required;
import play.db.jpa.Blob;
import play.db.jpa.Model;
import play.templates.JavaExtensions;
import utils.I18nUtil;

@Entity
@Table(name="vin")
public class Vin extends Model {

	@Required
	@NotNull
	@Column(unique=true)
	public String nom;

	@NotNull
	@Required
	@ManyToOne(fetch=FetchType.LAZY)
	public CouleurVin couleur;

	@NotNull
	@Required
	@ManyToOne(fetch=FetchType.LAZY)
	public Domaine domaine;

	@ManyToMany(targetEntity=Cepage.class, fetch=FetchType.LAZY)
	public List<Cepage> cepages;

	@ManyToOne(fetch=FetchType.LAZY)
	public Appellation appelation;

	public String millesime;

	public Float prix;

	@Column(name="photo_etiquette")
	public Blob photoEtiquette;

	public String video;

	@Lob
	@MaxSize(500)
	public String audio;


	@Lob
	@MaxSize(500)
	public String visuel;

	@Lob
	@MaxSize(500)
	public String arome;

	@Lob
	@MaxSize(500)
	public String mets;

	public Vin() {

	}

	@Override
	public String toString() {
		return nom;
	}


	/**
	 * Génère une url vers la fiche de l'objet
	 * @return
	 */
	public String generateUrl() {
		return String.format("/degustation/%d-%s.html", this.id, JavaExtensions.slugify(this.nom));
	}

	public String _arome() {
		return I18nUtil.get(this.arome);
	}

	public String _mets() {
		return I18nUtil.get(this.mets);
	}

	public String _visuel() {
		return I18nUtil.get(this.visuel);
	}

	public String _audio() {
		return I18nUtil.get(this.audio);
	}



}
