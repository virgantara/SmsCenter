/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms;

import java.util.ArrayList;
import java.util.List;
import org.smslib.AGateway;
import org.smslib.IInboundMessageNotification;
import org.smslib.InboundMessage;
import org.smslib.Message;

/**
 *
 * @author ASUS
 */
public class Inbox implements IInboundMessageNotification {

    private List<InboundMessage> msgList;
    
    public Inbox(){
        this.msgList = new ArrayList<>();
    }

    @Override
    public void process(AGateway gateway, Message.MessageTypes msgType, InboundMessage msg) {
        if (msgType == Message.MessageTypes.INBOUND) {
            System.out.println(">>>Pesan masuk pada gateway/modem: " + gateway.getGatewayId());
        } else if (msgType == Message.MessageTypes.STATUSREPORT) {
            System.out.println(">>>Laporan pengiriman pesan dari gateway: " + gateway.getGatewayId());
        }
        System.out.println("PESAN:");
        System.out.println(msg);
    }
    
    public List<InboundMessage> getMessages(){
        return this.msgList;
    }
}
