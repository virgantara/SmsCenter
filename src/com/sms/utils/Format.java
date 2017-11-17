/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms.utils;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 *
 * @author ASUS
 */
public class Format {
    public static boolean cekPhoneFormat(String phone){
        Pattern pattern = Pattern.compile("\\d{12}|\\d{11}");
        Matcher matcher = pattern.matcher(phone);

        boolean isValid = matcher.matches();
        
        return isValid;
    }
}
