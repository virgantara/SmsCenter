/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms.db;

import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;
import com.sms.entity.Kontak;
import com.sms.entity.KontakGroup;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

/**
 *
 * @author ASUS
 */
public class DBConnector {

    private Connection connection = null;

    public void init() {
        Properties prop = new Properties();
        InputStream input = null;
        try {

            input = new FileInputStream("config.properties");

            // load a properties file
            prop.load(input);

            // get the property value and print it out
            String host = prop.getProperty("host");
            String database = prop.getProperty("database");
            String username = prop.getProperty("username");
            String password = prop.getProperty("password");

            connect(host, database, username, password);

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

    private void connect(String host, String database, String username, String password) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
        } catch (ClassNotFoundException e) {
            System.out.println("Where is your MySQL JDBC Driver?");
            e.printStackTrace();
            return;
        }

        System.out.println("MySQL JDBC Driver Registered!");

        try {

            connection = (Connection) DriverManager.getConnection("jdbc:mysql://" + host + ":3306/" + database + "?zeroDateTimeBehavior=convertToNull&autoReconnect=true&characterEncoding=UTF-8&characterSetResults=UTF-8", username, password);

        } catch (SQLException e) {
            System.out.println("Connection Failed! Check output console : " + e.getMessage());

        }
    }

    public List<Kontak> getKontaks() {

        List<Kontak> list = new ArrayList<>();
        if (connection != null) {
            String query = "SELECT * "
                    + " FROM kontak k "
                    + " JOIN kontak_group kg ON k.contact_group = kg.group_id ";

            PreparedStatement preparedStatement = null;

            try {

                preparedStatement = (PreparedStatement) connection.prepareStatement(query);

                // execute select SQL stetement
                ResultSet rs = preparedStatement.executeQuery();
                int i = 0;
                while (rs.next()) {
                    i++;
                    int id = rs.getInt("kontak_id");
                    String nama = rs.getString("contact_name");
                    String phone = rs.getString("contact_phone");
                    String group = rs.getString("group_name");

                    Kontak k = new Kontak();
                    k.setKontakId(id);
                    k.setContactName(nama);
                    k.setContactPhone(phone);
                    k.setContactGroup(group);

                    list.add(k);
                }

            } catch (SQLException e) {

                System.err.println(e.getMessage());

            } finally {

                if (preparedStatement != null) {
                    try {
                        preparedStatement.close();
                    } catch (SQLException ex) {
                        System.out.println(ex.getMessage());
                    }
                }

            }

        }

        return list;
    }
}
