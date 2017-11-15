/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms;

import org.smslib.AGateway;
import org.smslib.ICallNotification;

/**
 *
 * @author ASUS
 */
public class CallNotification implements ICallNotification {

    @Override
    public void process(AGateway gateway, String callerId) {
        System.out.println(">>>Ada panggilan masuk: " + gateway.getGatewayId() + " : " + callerId);
    }
}
