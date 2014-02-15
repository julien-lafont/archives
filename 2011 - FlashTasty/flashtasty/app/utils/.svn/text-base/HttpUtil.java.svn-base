package utils;

import play.mvc.Controller;
import play.mvc.Http.Request;

public class HttpUtil {

	/**
	 * Retourne le referer ou / si il n'existe pas
	 * @return
	 */
	public static String referer() {

		String referer;
		try {
			referer = Request.current().headers.get("referer").value();
		} catch (Exception e) {
			referer="/";
		}
		return referer;
	}
}
