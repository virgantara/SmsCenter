/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms;

import com.sms.db.DBConnector;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.List;
import java.util.Properties;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import org.smslib.AGateway;
import org.smslib.AGateway.GatewayStatuses;
import org.smslib.GatewayException;
import org.smslib.InboundMessage;
import org.smslib.OutboundMessage;
import org.smslib.SMSLibException;
import org.smslib.Service;
import org.smslib.TimeoutException;
import org.smslib.modem.SerialModemGateway;

/**
 *
 * @author ASUS
 */
public class SmsService {

    private SerialModemGateway gateway = null;
    Inbox inbox = null;

    private GatewayStatuses status = null;
    private DBConnector db = null;

    public SmsService() {
        try {
            loadConfig();
            db = new DBConnector();
            db.init();
            inbox = new Inbox();
            //Setting notifikasi/pemberitahuan panggilan
            //jika ada panggilan masuk maka class/fungsi ini akan dijalankan
            CallNotification callNotification = new CallNotification();
            //Setting notifikasi/pemberitahuan perubahan status gateway
            //Jika status gateway berubah, bisa jadi berhenti, eroor dll, maka class ini akan dijalankan
            GatewayNotification statusNotification = new GatewayNotification(this);

            OrphanedNotification orphanedMessageNotification = new OrphanedNotification();

            gateway.setProtocol(AGateway.Protocols.PDU);

            // menggunakan modem sebagai penerima pesan
            gateway.setInbound(true);

            // menggunakan modem sebagai pengirim pesan
            gateway.setOutbound(true);

            // mengatur sim Pin (jika sim menggunakan pin, jika tidak masukan 0000)
            gateway.setSimPin("0000");

            // Setting notifikasi yang telah di inisialisasi sebelumnya kedalam gateway
            Service.getInstance().setInboundMessageNotification(inbox);
            Service.getInstance().setCallNotification(callNotification);
            Service.getInstance().setGatewayStatusNotification(statusNotification);
            Service.getInstance().setOrphanedMessageNotification(orphanedMessageNotification);

            // Menambahkan gateway ke service
            Service.getInstance().addGateway(gateway);
        } catch (GatewayException ex) {
            System.err.println(ex.getMessage());
        }
    }

    public int sendMessage(String phone, String message) {

        Pattern pattern = Pattern.compile("\\d{12}|\\d{11}");
        Matcher matcher = pattern.matcher(phone);

        int cond = 0;

        boolean isValid = matcher.matches();

        try {
            if (!isValid) {
                cond = 1;
            } else if (GatewayStatuses.STARTED != status) {
                cond = 2;
            } else {
                OutboundMessage outmsg = new OutboundMessage(phone, message);
                Service.getInstance().sendMessage(outmsg);
            }
        } catch (TimeoutException | GatewayException | IOException | InterruptedException ex) {
            System.err.println(ex.getMessage());
        }

        return cond;
    }

    private void loadConfig() {
        Properties prop = new Properties();
        InputStream input = null;
        try {

            input = new FileInputStream("config.properties");

            // load a properties file
            prop.load(input);

            // get the property value and print it out
            String port = prop.getProperty("port");
            String id = prop.getProperty("id");
            int baudrate = Integer.parseInt(prop.getProperty("baudrate"));
            String manufacturer = prop.getProperty("manufacturer");
            String model = prop.getProperty("model");

            gateway = new SerialModemGateway(id, port, baudrate, manufacturer, model);
        } catch (IOException ex) {
            System.err.println(ex.getMessage());
        } finally {
            if (input != null) {
                try {
                    input.close();
                } catch (IOException e) {
                    System.err.println(e.getMessage());
                }
            }
        }
    }

    public void stopService() {
        try {

            Service.getInstance().stopService();

        } catch (SMSLibException | IOException | InterruptedException ex) {
            System.err.println(ex.getMessage());
        }
    }

    public void startService() {
        try {
            Service.getInstance().startService();

            // Mengambil beberap informasi penting dari modem
            System.out.println();
            System.out.println("Detail Informasi Modem:");
            System.out.println("  Pembuat: " + gateway.getManufacturer());
            System.out.println("  Model: " + gateway.getModel());
            System.out.println("  Serial No: " + gateway.getSerialNo());
            System.out.println("  SIM IMSI: " + gateway.getImsi());
            System.out.println("  Signal: " + gateway.getSignalLevel() + " dBm");
            System.out.println("  Baterai: " + gateway.getBatteryLevel() + "%");
            System.out.println();

            //Mulai Membaca pesan
            List<InboundMessage> msgList = inbox.getMessages();
            Service.getInstance().readMessages(msgList, InboundMessage.MessageClasses.ALL);
            if (msgList.isEmpty()) {
                for (InboundMessage msg : msgList) {
                    System.out.println(msg);
                }
            } else {
                System.out.println("Saat ini, tidak ada pesan dalam modem");
            }
        } catch (SMSLibException | IOException | InterruptedException ex) {
            System.err.println(ex.getMessage());
        }
    }

    /**
     * @return the status
     */
    public GatewayStatuses getStatus() {
        return status;
    }

    /**
     * @param status the status to set
     */
    public void setStatus(GatewayStatuses status) {
        this.status = status;
    }
    
    public DBConnector getDB(){
        return this.db;
    }

}
