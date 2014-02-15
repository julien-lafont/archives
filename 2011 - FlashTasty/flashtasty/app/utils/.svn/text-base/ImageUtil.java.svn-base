package utils;

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Arrays;

import javax.imageio.IIOImage;
import javax.imageio.ImageIO;
import javax.imageio.ImageWriteParam;
import javax.imageio.ImageWriter;
import javax.imageio.stream.FileImageOutputStream;
import javax.imageio.stream.ImageOutputStream;

import play.db.jpa.Blob;

public class ImageUtil {

    private static final ArrayList<String> mimeAutorises = new ArrayList<String>() {{
    	add("image/jpg");
    	add("image/jpeg");
    	add("image/png");
    	add("image/gif");
    }};

    /**
     * Resize an image
     * @param originalImage The image file
     * @param to The destination file
     * @param w The new width (or -1 to proportionally resize)
     * @param h The new height (or -1 to proportionally resize)
     */
    public static void resize(Blob originalImage, File to, int w, int h) {
        try {
            BufferedImage source = ImageIO.read(originalImage.get());
            int owidth = source.getWidth();
            int oheight = source.getHeight();
            double ratio = (double) owidth / oheight;

            if (w < 0 && h < 0) {
                w = owidth;
                h = oheight;
            }
            if (w < 0 && h > 0) {
                w = (int) (h * ratio);
            }
            if (w > 0 && h < 0) {
                h = (int) (w / ratio);
            }


            String mimeType = originalImage.type();
            if (mimeAutorises.contains(mimeType)) {
                mimeType = "image/jpeg";
            }

            // out
            BufferedImage dest = new BufferedImage(w, h, BufferedImage.TYPE_INT_RGB);
            Image srcSized = source.getScaledInstance(w, h, Image.SCALE_SMOOTH);
            Graphics graphics = dest.getGraphics();
            graphics.setColor(Color.WHITE);
            graphics.fillRect(0, 0, w, h);
            graphics.drawImage(srcSized, 0, 0, null);
            ImageWriter writer = ImageIO.getImageWritersByMIMEType(mimeType).next();
            ImageWriteParam params = writer.getDefaultWriteParam();
            FileImageOutputStream toFs = new FileImageOutputStream(to);
            writer.setOutput(toFs);
            IIOImage image = new IIOImage(dest, null, null);
            writer.write(null, image, params);
            toFs.flush();
            toFs.close();

        } catch (Exception e) {
            throw new RuntimeException(e);
        }

    }


    public static InputStream resize(Blob originalImage, int w, int h) {
        try {
			File f = File.createTempFile(originalImage.getStore().getName()+w+h, null);
			resize(originalImage, f, w, h);
			InputStream is = new FileInputStream(f);
			return is;
		} catch (IOException e) {
			e.printStackTrace();
			return originalImage.get();
		}

    }
}
