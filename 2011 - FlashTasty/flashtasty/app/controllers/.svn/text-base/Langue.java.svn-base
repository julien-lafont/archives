package controllers;

import play.Logger;
import play.Play;
import play.mvc.Controller;
import play.mvc.Http.Header;
import play.mvc.Http.Request;
import utils.HttpUtil;
import utils.I18nUtil;

public class Langue extends Controller {

	public static void changer(String lang) {
		if (!Play.langs.contains(lang)) lang="fr";
		I18nUtil.change(lang);
		redirect(HttpUtil.referer());
	}
}
