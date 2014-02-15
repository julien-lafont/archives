package models;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Lob;
import javax.persistence.ManyToOne;
import javax.persistence.Table;

import net.sf.oval.constraint.Email;
import net.sf.oval.constraint.NotNull;

import play.data.validation.MaxSize;
import play.data.validation.Required;
import play.db.jpa.Blob;
import play.db.jpa.Model;
import utils.I18nUtil;

@Entity
@Table(name="domaine")
public class Domaine extends Model {

	@Required
	@NotNull
	@Column(unique=true)
	public String nom;

	@Column(name="nom_producteur")
	public String nomProducteur;

	@Lob
	@MaxSize(250)
	@Column(name="adresse_domaine")
	public String adresseDomaine;

	@Lob
	@MaxSize(250)
	@Column(name="adresse_pt_vene")
	public String adressePtVente;

	@Lob
	@MaxSize(500)
	@Column(name="bons_plans")
	public String bonsPlans;

	@Lob
	@MaxSize(500)
	@Column(name="descriptionProducteur")
	public String descriptionProducteur;

	@Lob
	@MaxSize(500)
	public String insolite;

	/*@play.data.validation.Email
	@Email*/
	public String email;

	@Column(name="photo_domaine")
	public Blob photoDomaine;

	@Column(name="photo_producteur")
	public Blob photoProducteur;

	@Column(name="photo_insolite")
	public Blob photoInsolite;

	@ManyToOne(fetch=FetchType.LAZY)
	@NotNull
	@Required
	public Vignoble vignoble;

	public String telephone;



	@Override
	public String toString() {
		return nom;
	}

	public String _bonsPlans() {
		return I18nUtil.get(bonsPlans);
	}

	public String _descriptionProducteur() {
		return I18nUtil.get(descriptionProducteur);
	}

	public String _insolite() {
		return I18nUtil.get(insolite);
	}

}
