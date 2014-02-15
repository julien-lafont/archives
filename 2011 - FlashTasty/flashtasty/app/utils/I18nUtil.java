package utils;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import play.Logger;
import play.i18n.Lang;

public class I18nUtil {

    public static final String DEFAULT_LANG = "fr";
    public static final String ATTRIBUTE_LANG = "lang";
    public static final String TAG_LANG = "text";

    public static String get(String xml) {

    	if (xml == null) return null;

        // Chaine simple : on la retourne directement
        if (!xml.startsWith("<text")) {
            return xml;

        } else {

            String lang = Lang.get();

            // Cas avec un <text> direct et langue FR
            if (lang.equals(DEFAULT_LANG)) {
            	Matcher m = Pattern.compile("<text>(.*)</text>").matcher(xml);
                if (m.lookingAt()) return m.group(1);
            }

            Document doc = Jsoup.parse(xml);
            if (doc == null) return xml;

            // On regarde si la langue désirée existe
            Elements nodes = doc.getElementsByAttributeValue(ATTRIBUTE_LANG, lang);
            if (nodes.size()>=1) {
                return nodes.get(0).html();
            } else {

                // Sinon on regarde si la langue par défaut existe
                nodes = doc.getElementsByAttributeValue(ATTRIBUTE_LANG, DEFAULT_LANG);
                if (nodes.size()>=1) {
                    return nodes.get(0).html();
                } else {

                    // Sinon on log l'erreur
                    Logger.error("Langue FR absente sur la donnee : ["+xml+"]");
                    return xml;
                }
            }
        }
    }

    public static void change(String lang) {
        Lang.change(lang);
    }
}
